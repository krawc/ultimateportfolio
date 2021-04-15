import React, { Component } from 'react';
import PropTypes from 'prop-types'
import ReactCSSTransitionGroup from 'react-addons-css-transition-group';
import SingleProject from './SingleProject.js';
import Image from 'react-blur-lazy-image';


class Work extends React.Component {
  constructor(props){
    super(props);
      this.state = {
          isVisible: true,
          projects: [],
          activeProject: false,
          activeProjects: [],
          activeSection: ''
      }
      this.switchActive = this.switchActive.bind(this);

      fetch('http://104.236.198.13/projects', {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json',
        }})
          .then(collections => collections.json())
          .then((collections) => { this.setState({projects: collections, activeProjects: collections}); console.log(collections)});

      this.closeComponent = ev => {
          ev.preventDefault();
          this.setState({
              isVisible: false
          });
      };
  }


switchActive(key) {
  const projects = this.state.projects;
  if ((projects !== []) && (key !== '')) {
    const newActive = projects.filter(project => project.type.includes(key));
    // console.log(newActive);
    this.setState({
      activeProjects: newActive,
      activeSection: key
    });
  } else {
    this.setState({
      activeProjects: projects,
      activeSection: ''
    });
  }
}

render() {

  const projects = this.state.activeProjects.map((item, key) => {

    return (
      <article className="work-project" onClick={() => this.props.changeActive(item.id)}>
        <img className="work-project__img" src={'http://104.236.198.13' + item.thumbnail.url}/>
        <div className="work-project__description"><h1>{item.title}</h1></div>
      </article>
    )
  });


  return (
    this.state.isVisible ?
    <div id="Work" className={this.props.videoEnded ? 'loaded' : 'loading'}>
      <header className="page-header">
        <h1>
          <a className={"section-link " + (this.state.activeSection === '' ? 'active' : '')} onClick={() => this.switchActive('')}>ALL</a>
          <a className={"section-link " + (this.state.activeSection === 'work' ? 'active' : '')} onClick={() => this.switchActive('work')}>WORK</a>
          <a className={"section-link " + (this.state.activeSection === 'play' ? 'active' : '')} onClick={() => this.switchActive('play')}>PLAY</a>
          <a className="section-link" target="_blank" href="https://medium.com/@krawc" >WRITING</a>
        </h1>
      </header>
      <main className={"work-projects"}>
        {projects}
      </main>
    </div>

    :
    null
  );
}
}

export default Work;
