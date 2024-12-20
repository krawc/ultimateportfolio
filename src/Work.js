import React, { useContext, Component } from 'react';
import PropTypes from 'prop-types'
import ReactCSSTransitionGroup from 'react-addons-css-transition-group';
import SingleProject from './SingleProject.js';
import Image from 'react-blur-lazy-image';
import ProjectsContext from './ProjectsContext';







// https://www.dropbox.com/scl/fi/sltjnc89mc6qqcbx5eu56/aic.png?rlkey=z604xmbofuini5qhpqqhmg9hn&st=0bbiei73&raw=1

// https://www.dropbox.com/scl/fi/azvg44j5fijpj8mwauib7/aic2.png?rlkey=7vhzqc4i7rhyjbrxsvsty8b9l&st=vsm7ruff&raw=1

// https://www.dropbox.com/scl/fi/xak7nhglp0gaekmovxwf9/artifice.jpeg?rlkey=l4j735ojmb4l2ye4ixre9n5sa&st=qvq4axft&raw=1

// https://www.dropbox.com/scl/fi/qetdz6l06c4h0m1x8uwzf/artmo1.png?rlkey=q2nufrnlt2m8prrwihtdmnb2v&st=kn44i7z4&raw=1

// https://www.dropbox.com/scl/fi/e9f8q6u5tdex1ltrf3poq/artmo2.png?rlkey=lfpf7agdmpd1h0ark1v0lzutu&st=wt6rcfto&raw=1

// https://www.dropbox.com/scl/fi/lgx20g2ha68nkrdo8i76e/bits1.png?rlkey=obt0xt8h4gxift6y19dwual5h&st=23urr9td&raw=1

// https://www.dropbox.com/scl/fi/elcbtsrspl9xhv0utqxvp/bits2.png?rlkey=u7cv6zvltztdxie7j2zuk02kv&st=q5rtfmmy&raw=1

// https://www.dropbox.com/scl/fi/wb378yvi3djhn6f418lg9/bits3.png?rlkey=ptqju1gcwqyffv9ngzoletjwm&st=bfoddkyp&raw=1

// https://www.dropbox.com/scl/fi/84exkzd1yy76qbw5ndqhb/bos.png?rlkey=k29ssau3llt4jrmt7ubgkzjw9&st=3x562xfa&raw=1

// https://www.dropbox.com/scl/fi/npohqglkipvtw8s5oiujy/eureka.png?rlkey=sblx14yhiiovl5uuwcodfx70r&st=bqftda0o&raw=1

// https://www.dropbox.com/scl/fi/vkmx0ve5gmj2t5ftqrzzd/eureka2.png?rlkey=z0ctbsequpcbrk2k6xdmif4ui&st=ef3wl8z9&raw=1

// https://www.dropbox.com/scl/fi/6f5rpy3fubiaic1c50bol/ilive.jpeg?rlkey=271ovm910yrl7n8v2pyp1nxpl&st=yoha07g7&raw=1

// https://www.dropbox.com/scl/fi/ntjia5khzwsybaanh7bdx/ilive2.jpeg?rlkey=5vwy5xqspgy2f1pen1btcchg6&st=c6xp31i3&raw=1

// https://www.dropbox.com/scl/fi/q8cir58ynuj6irdmjsuaq/ima.png?rlkey=4tt71eaeibz9p2poayjbbfc9g&st=3snfrjja&raw=1

// https://www.dropbox.com/scl/fi/vtt48guyan2xypbw5k9vt/ink1.png?rlkey=0ozeo4f0fh1qzry2cy8lqlhyz&st=67wzozof&raw=1

// https://www.dropbox.com/scl/fi/ycp1lhdbqy9dkouc228te/ink2.png?rlkey=tnck4k1qqgxsnd0wneipszekr&st=frs9fqa7&raw=1

// https://www.dropbox.com/scl/fi/9q69n4fpythjjrdmp14jt/lr.jpeg?rlkey=33kflaslfgzt4l02p18tl6rws&st=7nuardzz&raw=1

// https://www.dropbox.com/scl/fi/exxw3icze6y4iget69o9x/lr2.png?rlkey=ipkj3l15icfcrsuo2x19b7rx2&st=qds9zw5x&raw=1

// https://www.dropbox.com/scl/fi/arf25lsazpmswrsblddcb/mia_preview.png?rlkey=t7cbuve2am8zwto2snu0wqzw6&st=mmni9mht&raw=1

// https://www.dropbox.com/scl/fi/j2vgn4gejjy0113ahmxbd/picnic_full.png?rlkey=q03v69u03h3eng55zmk59v2om&st=45dq7mk3&raw=1

// https://www.dropbox.com/scl/fi/0siwop20yzufva69j7xod/picnic.png?rlkey=iasezr6pknom0s9vg1ai1grnv&st=inkmfx9q&raw=1

// https://www.dropbox.com/scl/fi/asmqn8bv17b29zjzavglj/tut.png?rlkey=tpya1fcbt5wdqk7eh54x3r26n&st=4t82kmrt&raw=1

// https://www.dropbox.com/scl/fi/mmz5bsqe2nbdpwtx4wica/tutoringpract.png?rlkey=a6dhv4fao0bswtmfbsct52y9c&st=mnry81le&raw=1






class Work extends React.Component {

  static contextType = ProjectsContext;

  constructor(props, context){
    super(props);
    const projectsRaw = context;
      this.state = {
          isVisible: true,
          projects: projectsRaw,
          activeProject: false,
          activeProjects: projectsRaw,
          activeSection: ''
      }
      this.switchActive = this.switchActive.bind(this);

      // fetch('https://strapi-cx4y.onrender.com/api/projects?populate=*', {
      //   method: 'GET',
      //   headers: {
      //     'Content-Type': 'application/json',
      //   }})
      //     .then(collections => collections.json())
      //     .then((collections) => { this.setState({projects: collections.data, activeProjects: collections.data}); console.log(collections)});

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
        <img className="work-project__img" src={item.images[0]}/>
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
