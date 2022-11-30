import React, { Component } from 'react';
import PropTypes from 'prop-types'
import { BrowserRouter as Router, Route, Link } from 'react-router-dom';
import ReactCSSTransitionGroup from 'react-addons-css-transition-group';
import Work from './Work.js';
import { push as Menu } from 'react-burger-menu';
import Image from 'react-blur-lazy-image';
import { send } from 'emailjs-com';


class Home extends React.Component {
  constructor(props){
    super(props);



    this.openAgenda = this.openAgenda.bind(this);
    this.videoEnded = this.videoEnded.bind(this);
    this.changeActive = this.changeActive.bind(this);
    this.handleChange = this.handleChange.bind(this);
    this.onSubmit = this.onSubmit.bind(this);

      this.state = {
          isVisible: true,
          videoURL: false,
          videoEnded: false,
          videoOpened: sessionStorage.getItem('opened'),
          message: '',
          messageSent: false,
          toSend: {
            from_name: 'Visitor',
            to_name: 'Konrad',
            message: '',
            reply_to: '',
          }
      }

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

  onSubmit = (e) => {
    e.preventDefault();
    this.setState({
      messageSending: true
    });
    send(
      'service_scljtpn',
      'template_0raz3nj',
      this.state.toSend,
      'user_Vq4Il6NwpgjuD9VVj5fc1'
    )
      .then((response) => {
        console.log('SUCCESS!', response.status, response.text);
      })
      .then(this.setState({
        messageSent: true,
        messageSending: false
      }))
      .catch((err) => {
        console.log('FAILED...', err);
        this.setState({
          messageSending: false
        });
      });
  }

  handleChange = (e) => {
    this.setState({toSend: { ...this.state.toSend, [e.target.name]: e.target.value }});
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
          <p className="menu-item">I experiment with combining technological layers to provide tools for creative production, and to tell stories of the future social change.</p>
          <p>Graduated from NYU Shanghai's IMA program in 2019. Currently parked in Delft.</p>
          <h3>Wanna work together?<br/>Send me a message:</h3>
            <form onSubmit={this.onSubmit}>
              <input
                type='text'
                name='reply_to'
                placeholder='Your email'
                value={this.state.toSend.reply_to}
                onChange={this.handleChange}
              />
                <textarea name="message" onChange={this.handleChange} id="message">{this.state.toSend.message}</textarea>
              <button type="submit" value="Submit">{this.state.messageSent ? 'SENT!' : (this.state.messageSending ? 'PROCESSING...' : 'SEND')}</button>
            </form>
      </Menu>
        <div id="Home" class={!this.state.videoOpened ? 'overflow-hidden' : ''}>
          <div className="Home-social">
            <a target="_blank" href="https://github.com/krawc"><i className="ion ion-social-github"></i></a>
            <a target="_blank" href="https://twitter.com/konradkrawc"><i className="ion ion-social-twitter"></i></a>
            <a target="_blank" href="https://www.linkedin.com/in/konradkrawc/"><i className="ion ion-social-linkedin"></i></a>
          </div>
          <Work videoEnded={this.state.videoEnded} changeActive={this.changeActive}/>

          {/* {(!this.state.videoOpened && !(/Android|webOS|iPhone|iPad|iPod|BlackBerry|BB|PlayBook|IEMobile|Windows Phone|Kindle|Silk|Opera Mini/i.test(navigator.userAgent)))?
          <div className={"background " + (this.state.videoEnded ? "roll" : "")}>
            <button id="show-work" onClick={this.videoEnded}>SHOW WORK</button>
          </div>
          :
          <div/>
          } */}
        </div>
      </div>
      :
      null}
      </ReactCSSTransitionGroup>
    );
  }
}

export default Home;
