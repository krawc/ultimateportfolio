import React, { Component } from 'react';
import PropTypes from 'prop-types'
import { BrowserRouter as Router, Route, Link } from 'react-router-dom';
import ReactCSSTransitionGroup from 'react-addons-css-transition-group';
import Work from './Work.js';
import { push as Menu } from 'react-burger-menu';
import Image from 'react-blur-lazy-image';


class Home extends React.Component {
  constructor(props){
    super(props);



    this.openAgenda = this.openAgenda.bind(this);
    this.videoEnded = this.videoEnded.bind(this);
    this.changeActive = this.changeActive.bind(this);
    this.handleChange = this.handleChange.bind(this);
    this.handleSubmit = this.handleSubmit.bind(this);

      this.state = {
          isVisible: true,
          videoURL: false,
          videoEnded: false,
          videoOpened: sessionStorage.getItem('opened'),
          message: '',
          messageSent: false
      }

      fetch('https://krawc.space/api/singletons/get/vid?token=e2949d4cfc3fb48cb1803670f3f61a')
          .then(collections => collections.json())
          // .then(collections => console.log(collections))
          .then(collections => this.setState({videoURL: collections.video}));

      this.video = React.createRef();

      this.closeComponent = ev => {
        this.setState({
            isVisible: false,
            agendaOpen: false,
        });
          setTimeout(() => {
              this.props.history.push('/work')
          }, 600)
      }
  }

  changeActive(key) {
    this.setState({
        isVisible: false,
    });
    setTimeout(() => {
        this.props.history.push('/project?id=' + key)
    }, 600);
  }

  videoEnded() {
    if (!sessionStorage.getItem('opened')) {
      sessionStorage.setItem('opened', true);
    }
    this.setState({
      videoEnded: true,
    });
    setTimeout(() => {
      this.setState({
        videoOpened: true,
      })
    }, 400);
  }

  openAgenda() {
    this.setState({
      agendaOpen: true,
      videoTime: this.video.currentTime
    });
  }

  handleChange(event) {
    this.setState({message: event.target.value});
  }

  handleSubmit(event) {
    fetch('https://krawc.space/api/forms/submit/contact?token=e2949d4cfc3fb48cb1803670f3f61a', {
        method: 'post',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            form: {
                message: this.state.message,
            }
        })
    })
    .then(entry => entry.json())
    .then(entry => console.log(entry))
    .then(this.setState({
      messageSent: true
    }));

    event.preventDefault();

  }

  render() {
    return (
      <ReactCSSTransitionGroup
    transitionAppear={true}
    transitionAppearTimeout={400}
    transitionEnterTimeout={400}
    transitionLeaveTimeout={400}
    transitionName={'loadComponent'}
>
    {this.state.isVisible ?
      <div id="outer-container">
        <Menu pageWrapId={ "Home" } width={400} outerContainerId={ "outer-container" } customBurgerIcon={ <button>ABOUT ME</button> }>
          <h3>Hi! I'm Konrad.</h3>
          <p className="menu-item">I'm a web developer involved with interactive civic and social technology. About to graduate from NYU Shanghai, with a major in Interactive Media Arts and minor in Social Science, as well as 2 years of commercial experience in development and design. </p>
          <h3>Wanna work together?<br/>Send me a message:</h3>
            <form onSubmit={this.handleSubmit}>
              <textarea name="message" onChange={this.handleChange} id="message">{this.state.message}</textarea>
              <button type="submit" value="Submit">{this.state.messageSent ? 'SENT!' : 'SEND'}</button>
            </form>
      </Menu>
        <div id="Home" class={!this.state.videoOpened ? 'overflow-hidden' : ''}>
          <div className="Home-social">
            <a target="_blank" href="https://github.com/krawc"><i className="ion ion-social-github"></i></a>
            <a target="_blank" href="https://twitter.com/konradkrawc"><i className="ion ion-social-twitter"></i></a>
            <a target="_blank" href="https://www.linkedin.com/in/konradkrawc/"><i className="ion ion-social-linkedin"></i></a>
          </div>
          <Work videoEnded={this.state.videoEnded} changeActive={this.changeActive}/>

          {(!this.state.videoOpened && !(/Android|webOS|iPhone|iPad|iPod|BlackBerry|BB|PlayBook|IEMobile|Windows Phone|Kindle|Silk|Opera Mini/i.test(navigator.userAgent)))?
          <div className={"background " + (this.state.videoEnded ? "roll" : "")}>
            <video ref={this.video} src={"https://krawc.space/" + this.state.videoURL} autoPlay muted onEnded={this.videoEnded}></video>
            <button id="show-work" onClick={this.videoEnded}>SHOW WORK</button>
          </div>
          :
          <div/>
          }
        </div>
      </div>
      :
      null}
      </ReactCSSTransitionGroup>
    );
  }
}

export default Home;
