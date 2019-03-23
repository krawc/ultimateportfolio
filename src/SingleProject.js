import React from 'react'
import PropTypes from 'prop-types'
import { BrowserRouter as Router, Route, Link } from 'react-router-dom';
import ReactCSSTransitionGroup from 'react-addons-css-transition-group';
import Image from 'react-blur-lazy-image';

class SingleProject extends React.Component {

  constructor(props) {

    super(props);

    this.handleKeyDown = this.handleKeyDown.bind(this);
    this.slideBack = this.slideBack.bind(this);
    this.slideForward = this.slideForward.bind(this);

    this.state = {
      isVisible: true,
      loaded: false,
      currentSlide: 0,
      project: false,
      galleryLength: 0
    }

    const params = new URLSearchParams(props.location.search);
    const POSTID = params.get('id');
    console.log(POSTID);


    fetch('https://krawc.space/api/collections/get/work?token=e2949d4cfc3fb48cb1803670f3f61a', {
        method: 'post',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            filter: {_id: POSTID}
        })
      })
        .then(collections => collections.json())
        .then(collections => this.setState({project: collections.entries[0]}))
        .then(collections => this.setState({loaded: true}))
        .then(collections => this.setState({galleryLength: this.state.project.gallery.length}));

    this.backToWork = ev => {
        ev.preventDefault();
        this.setState({
            isVisible: false,
        });
        setTimeout(() => {
            this.props.history.push('/')
        }, 600)
    }
  }

  handleKeyDown(e) {
    // arrow up/down button should select next/previous list element
    if (e.keyCode === 37) {
      console.log('this');
      this.slideBack();
    } else if (e.keyCode === 39) {
      this.slideForward();
    }
  }

  slideBack(e) {
    let slide = this.state.currentSlide;
    let photos = this.state.project.gallery;
    let nextSlide = (slide - 1) % photos.length;
    if (nextSlide < 0) {
      nextSlide += photos.length;
    }
    this.setState({
      currentSlide: nextSlide
    });
  }

  slideForward(e) {
    let slide = Math.abs(this.state.currentSlide);
    let photos = this.state.project.gallery;
    let nextSlide = (slide + 1) % photos.length;
    this.setState({
      currentSlide: nextSlide
    });
  }

  componentDidMount(){
      document.addEventListener("keydown", this.handleKeyDown);
  }

  render() {

    const images = this.state.project ? this.state.project.gallery.map((item, key) => {
      return (
        <div className="single-image">
          <Image src={'https://krawc.space/' + item.path} altSrc={'https://krawc.space/' + item.mini} />
          <i className="ion ion-load-d"></i>
        </div>
      )
    })
    :
    ''

    return (
      <ReactCSSTransitionGroup
    transitionAppear={true}
    transitionAppearTimeout={400}
    transitionEnterTimeout={400}
    transitionLeaveTimeout={400}
    transitionName={'SingleProject'}
>

    {this.state.isVisible ?
      <div className={"SingleProject " + (this.state.loaded ? 'toggled' : 'untoggled')}>
        <div className="SingleProject-content">
          <h1><button className="Home-buttons" onClick={this.backToWork}><i className="ion ion-chevron-left"></i>{" BACK"}</button><a target="_blank" href={this.state.project.link}>{this.state.project.title}</a></h1>
          <div className="SingleProject-paragraph" dangerouslySetInnerHTML={{__html: this.state.project.content}} />
        </div>
          <div className="SingleProject-image">
            <div className="SingleProject-slider" style={{transform: 'translateX(-' + (this.state.currentSlide * 100) + '%)'}}>
            {images}
            </div>
            <div className={"SingleProject-arrows "} style={{position: 'absolute', }}>
              <i className={"ion ion-chevron-left " + (this.state.currentSlide > 0 ? "arrow-show" : "arrow-hide")} onClick={this.slideBack}></i>
              <i className={"ion ion-chevron-right " + ((this.state.galleryLength - 1) === this.state.currentSlide ? "arrow-hide" : "arrow-show")} onClick={this.slideForward}></i>
            </div>
          </div>
      </div>
      :
      null}
      </ReactCSSTransitionGroup>
    )
  }
}

export default SingleProject;
