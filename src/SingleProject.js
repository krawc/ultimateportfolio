import React from 'react'
import PropTypes from 'prop-types'
import { BrowserRouter as Router, Route, Link } from 'react-router-dom';
import ReactCSSTransitionGroup from 'react-addons-css-transition-group';
import Image from 'react-blur-lazy-image-noscroll';
import { Remarkable } from 'remarkable';


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
      project: {
        id: 0,
        attributes: {
          title: "",
          description: "",
          type: "play",
          images: {
            data: []
          }
        }
      },
      galleryLength: 0,
      images: ''
    }

    const params = new URLSearchParams(props.location.search);
    const POSTID = params.get('id');
    console.log(POSTID);


    fetch('https://strapi-cx4y.onrender.com/api/projects/' + POSTID + '?populate=*', {
        method: 'get',
        headers: { 'Content-Type': 'application/json' }
      })
        .then(collections => collections.json())
        .then((collections) => {this.setState({project: collections.data}); console.log(collections.data);})
        .then(collections => this.setState({loaded: true}))
        .then(collections => this.setState({galleryLength: this.state.project.attributes.images.data.length}));


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
    let photos = this.state.project.attributes.images.data;
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
    let photos = this.state.project.attributes.images.data;
    let nextSlide = (slide + 1) % photos.length;
    this.setState({
      currentSlide: nextSlide
    });
  }

  componentDidMount(){

      document.addEventListener("keydown", this.handleKeyDown);


  }

  render() {

    var md = new Remarkable();



    const images = this.state.project ? this.state.project.attributes.images.data.map((item, key) => {
      return (
        <div className="single-image">
          <Image container={this.imageContainer1} src={'https://strapi-cx4y.onrender.com/api/' + item.attributes.url} altSrc={'https://strapi-cx4y.onrender.com/api/' + item.attributes.formats.thumbnail.url} />
          <i className="ion ion-load-d"></i>
        </div>
      )
    })
    :
    ''

    return (
      <ReactCSSTransitionGroup
    transitionAppear={true}
    transitionAppearTimeout={600}
    transitionEnterTimeout={600}
    transitionEnter={true}
    transitionLeaveTimeout={600}
    transitionLeave={true}
    transitionName={'SingleProject'}
    >

    {this.state.isVisible ?
      <div className={"SingleProject " + (this.state.loaded ? 'toggled' : 'untoggled')}>
        <div className="SingleProject-content">
          <h1><button className="Home-buttons" onClick={this.backToWork}><i className="ion ion-chevron-left"></i>{" BACK"}</button><a target="_blank" href={this.state.project.id}>{this.state.project.attributes.title}</a></h1>
          <div className="SingleProject-paragraph" dangerouslySetInnerHTML={{__html: md.render(this.state.project.attributes.description)}} />
        </div>
          <div className="SingleProject-image">
            <div className="SingleProject-slider" unmountonexit ref={(node) => { this.imageContainer1 = node; }} style={{transform: 'translateX(-' + (this.state.currentSlide * 100) + '%)'}}>
            {images}
            <div className="single-image">
            <Image src={'https://krawc.space/'} altSrc={'https://krawc.space/'} />
            <i className="ion ion-load-d"></i>
          </div>
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
