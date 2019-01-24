import React from 'react'
import PropTypes from 'prop-types'
import ReactCSSTransitionGroup from 'react-addons-css-transition-group';
import SingleProject from './SingleProject.js';

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

      fetch('http://krawc.space/api/collections/get/work?token=e2949d4cfc3fb48cb1803670f3f61a')
          .then(collections => collections.json())
          .then(collections => this.setState({projects: collections.entries, activeProjects: collections.entries}));

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
    const newActive = projects.filter(project => project.category.includes(key));
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
      <article className="work-project" onClick={() => this.props.changeActive(item._id)}>
        <img className="work-project__img" src={'http://krawc.space/' + item.image.path}/>
        <div className="work-project__description"><h1>{item.title}</h1></div>
      </article>
    )
  });


  return (
    this.state.isVisible ?
    <div id="Work" className={this.props.videoEnded ? 'loaded' : ''}>
      <header className="page-header">
        <h1>
          <a className={"section-link " + (this.state.activeSection === '' ? 'active' : '')} onClick={() => this.switchActive('')}>ALL</a>
          <a className={"section-link " + (this.state.activeSection === 'web' ? 'active' : '')} onClick={() => this.switchActive('web')}>WEB</a>
          <a className={"section-link " + (this.state.activeSection === 'design' ? 'active' : '')} onClick={() => this.switchActive('design')}>DESIGN</a>
          <a className={"section-link " + (this.state.activeSection === 'play' ? 'active' : '')} onClick={() => this.switchActive('play')}>PLAY</a>
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
