import React, { Component } from 'react';
import logo from './logo.svg';
import './App.css';
import { BrowserRouter as Router, Route, Link, Switch, Redirect } from 'react-router-dom';
import Work from './Work.js';
import Home from './Home.js';
import SingleProject from './SingleProject.js';
import ProjectsContext from './ProjectsContext';



const projectsRaw = [
  {
    "id": 1,
    "title": "BMW AG",
    "description": "During my internship at BMW's in-car voice assistant team, I supported the integration of large language models into automotive UX. My work helped define the assistant's interaction style by contributing to the development of a fine-tuning dataset and prompt design. A feedback platform I co-developed enabled compliant, large-scale collection of user preferences around verbosity. Insights from user studies shaped key design decisions and contributed directly to team-wide strategy updates. I also helped improve onboarding UX in the demo app, making the assistant easier to showcase to internal and external stakeholders.",
    "type": "work",
    "year": "2025",
    "links": [
      {
        "title": "HUD ISLAND",
        "btnText": "VIEW DESIGN",
        "url": "https://www.figma.com/proto/iJS5uppZ4LN6aYKB1cheev/Chat-BMW-island?page-id=10%3A16&node-id=13-1621&starting-point-node-id=13%3A1621&scaling=scale-down-width&content-scaling=fixed&show-proto-sidebar=1&t=ABtnzJ6NtxqnHdXt-1",
        "img": "https://www.dropbox.com/scl/fi/3brilbdwe0oipe1z8bkio/bmw1.png?rlkey=e6549e6fc0zo2n49wjr83dkui&st=jmyai39z&raw=1"
      },
      {
        "title": "HUMAN FEEDBACK & ANSWER LENGTH",
        "btnText": "VIEW CASE STUDY",
        "url": "https://www.figma.com/slides/444PWwPIrL52rwRWtWgrnO/LLM-Human-Feedback-Strategy---case-study?node-id=1-352&t=DCnpHFrQDmpE0Whq-1",
        "img": "https://www.dropbox.com/scl/fi/hdy9a9elfmeves7sz0s1c/bmw2.png?rlkey=jewl441r7glxv6nmrph2qcfm0&st=68aev8dl&raw=1"
      }
    ],
    "images": [
      "https://www.dropbox.com/scl/fi/3brilbdwe0oipe1z8bkio/bmw1.png?rlkey=e6549e6fc0zo2n49wjr83dkui&st=jmyai39z&raw=1",
      "https://www.dropbox.com/scl/fi/hdy9a9elfmeves7sz0s1c/bmw2.png?rlkey=jewl441r7glxv6nmrph2qcfm0&st=68aev8dl&raw=1"
    ]
  },
  // {
  //   "id": 10,
  //   "title": "Visio Voice",
  //   "description": "Summer 2024. Thesis Project at TU Delft. This research project investigates the challenges faced by blind and low-vision (BLV) individuals in using digital technologies, particularly focusing on the usability and accessibility of voice assistant technologies. The study aims to identify key problems experienced by BLV users, analyze the limitations and recent developments in voice assistant technology, and co-create a solution aimed at enhancing the usability of voice assistants for non-visual users. To achieve these objectives, a mixed-methods approach was employed, including a literature review, usability inspections, digital anthropology, as well as co-design sessions with Visio experts and prototype testing with BLV users to validate potential solutions.",
  //   "type": "work",
  //   "year": "2024",
  //   "images": [
  //     "https://www.dropbox.com/scl/fi/f3aizunpigjqimkvhtoe7/thesis0.png?rlkey=ssmx19cqn8u41z8ep1o2htpk4&st=8vx0ywtb&raw=1",
  //     "https://www.dropbox.com/scl/fi/fnrc87kfu8xba73gewuo9/thesis1.png?rlkey=hvhkaj1kf5xvtz6yu2vqrkdtq&st=2t9d578y&raw=1"
  //   ]
  // },
  {
    "id": 12,
    "title": "eureka",
    "description": "Spring 2024. Vision in Product Project at TU Delft. This project explores innovative approaches to international train travel by addressing current preconceptions and leveraging modern lifestyle shifts. Central to the project is a travel planning tool designed to enhance the quality of door-to-door travel. This tool provides users with a quality-oriented view of their journey, highlighting not just logistics but also cognitive aspects of their travel time. By visualizing occupied, idle, and free time, and incorporating information on amenities and multimodal connections, the tool encourages process-oriented choices, nudging users toward sustainable ground transit options.",
    "type": "play",
    "year": "2024",
    "images": [
      "https://www.dropbox.com/scl/fi/npohqglkipvtw8s5oiujy/eureka.png?rlkey=sblx14yhiiovl5uuwcodfx70r&st=bqftda0o&raw=1",
      "https://www.dropbox.com/scl/fi/vkmx0ve5gmj2t5ftqrzzd/eureka2.png?rlkey=z0ctbsequpcbrk2k6xdmif4ui&st=ef3wl8z9&raw=1"
    ]
  },
  {
    "id": 2,
    "title": "bits & pieces",
    "description": "Fall 2022. Exploring Interactions Project at TU Delft. This product was developed to help visitors of Kunstmuseum Den Haag find meaning in abstract art. It consists of cue cards, packaged in a stylish paper box with a black ribbon handle, designed to guide users through the phases 'See,' 'Think,' and 'Feel' to deepen their understanding of artwork. The cards are made from durable materials and feature a minimalistic, abstract aesthetic.",
    "type": "play",
    "year": "2022",
    "images": [
      "https://www.dropbox.com/scl/fi/lgx20g2ha68nkrdo8i76e/bits1.png?rlkey=obt0xt8h4gxift6y19dwual5h&st=23urr9td&raw=1",
      "https://www.dropbox.com/scl/fi/elcbtsrspl9xhv0utqxvp/bits2.png?rlkey=u7cv6zvltztdxie7j2zuk02kv&st=q5rtfmmy&raw=1",
      "https://www.dropbox.com/scl/fi/wb378yvi3djhn6f418lg9/bits3.png?rlkey=ptqju1gcwqyffv9ngzoletjwm&st=bfoddkyp&raw=1"
    ]
  },
  {
    "id": 3,
    "title": "Picnic Re-design",
    "description": "Spring 2023. User eXperience Assessment in Design at TU Delft. This group project for Picnic, an online grocery shopping service, aimed to enhance app features for greater user control and flexibility. Catering to identified personas 'Manager' and 'Chef,' the redesign improved product search, cart categorization, and dietary preference personalization. User tests showed significant success with a 7/10 target achievement.",
    "type": "work",
    "year": "2023",
    "images": [
      "https://www.dropbox.com/scl/fi/0siwop20yzufva69j7xod/picnic.png?rlkey=iasezr6pknom0s9vg1ai1grnv&st=inkmfx9q&raw=1",
      "https://www.dropbox.com/scl/fi/0siwop20yzufva69j7xod/picnic.png?rlkey=iasezr6pknom0s9vg1ai1grnv&st=inkmfx9q&raw=1"
    ]
  },
  {
    "id": 4,
    "title": "artmo",
    "description": "2018 - now. Industry Project. Shanghai - Lisbon - Remote. ARTMO is a social platform for art promotion, curation, and sales, currently with 150,000+ users. Its commission-free approach challenges traditional art sales models while providing marketing tools for established institutions and empowering independent artists and buyers worldwide. As a co-founder and product lead, I managed user research, UI prototypes, front-end development, and project management.",
    "type": "work",
    "year": "2018",
    "images": [
      "https://www.dropbox.com/scl/fi/qetdz6l06c4h0m1x8uwzf/artmo1.png?rlkey=q2nufrnlt2m8prrwihtdmnb2v&st=kn44i7z4&raw=1",
      "https://www.dropbox.com/scl/fi/e9f8q6u5tdex1ltrf3poq/artmo2.png?rlkey=lfpf7agdmpd1h0ark1v0lzutu&st=wt6rcfto&raw=1"
    ]
  },
  {
    "id": 5,
    "title": "LiveRoom",
    "description": "2020 - 2021. Industry Project. Remote. LiveRoom Media addresses the lack of online monetization and networking opportunities in the music industry post-COVID-19. It offers a platform for musicians to monetize performances, network, and upskill. As technical lead, I supported these initiatives through targeted solutions.",
    "type": "work",
    "year": "2020",
    "images": [
      "https://www.dropbox.com/scl/fi/9q69n4fpythjjrdmp14jt/lr.jpeg?rlkey=33kflaslfgzt4l02p18tl6rws&st=7nuardzz&raw=1",
      "https://www.dropbox.com/scl/fi/exxw3icze6y4iget69o9x/lr2.png?rlkey=ipkj3l15icfcrsuo2x19b7rx2&st=qds9zw5x&raw=1"
    ]
  },
  {
    "id": 6,
    "title": "iLiveInPublic",
    "description": "Fall 2019. Interactive Media Arts thesis at NYU Shanghai, supervised by Allison de Fren. This project explores the concept of the 'digital panopticon' through an 8-hour performance experiment where every interaction with the web was recorded and transformed into algorithm-feeding data. It was later presented at a conference at the China Academy of Art in December 2021.",
    "type": "play",
    "year": "2019",
    "images": [
      "https://www.dropbox.com/scl/fi/6f5rpy3fubiaic1c50bol/ilive.jpeg?rlkey=271ovm910yrl7n8v2pyp1nxpl&st=yoha07g7&raw=1",
      "https://www.dropbox.com/scl/fi/ntjia5khzwsybaanh7bdx/ilive2.jpeg?rlkey=5vwy5xqspgy2f1pen1btcchg6&st=c6xp31i3&raw=1"
    ]
  },
  {
    "id": 7,
    "title": "BossySuits",
    "description": "Fall 2018. This project focused on creating a subscription-based professional apparel brand for millennials. As part of a team, I developed a JavaScript-based e-commerce extension to automate unique package generation based on customer data. The entire order-to-package generation process was reduced to two clicks.",
    "type": "work",
    "year": "2018",
    "images": [
      "https://www.dropbox.com/scl/fi/84exkzd1yy76qbw5ndqhb/bos.png?rlkey=k29ssau3llt4jrmt7ubgkzjw9&st=3x562xfa&raw=1",
      "https://www.dropbox.com/scl/fi/e9f8q6u5tdex1ltrf3poq/bos1.png?rlkey=lfpf7agdmpd1h0ark1v0lzutu&raw=1"
    ]
  },
  {
    "id": 8,
    "title": "inklined",
    "description": "Fall 2018. A generative art project paying tribute to Franz Kline's abstract expressionism. Using p5.js, I created functions that leveraged randomization and Perlin noise to produce calligraphic, abstract visuals. One of the pieces, inklined #1, was sold as an NFT on mintable.app.",
    "type": "play",
    "year": "2018",
    "images": [
      "https://www.dropbox.com/scl/fi/vtt48guyan2xypbw5k9vt/ink1.png?rlkey=0ozeo4f0fh1qzry2cy8lqlhyz&st=67wzozof&raw=1",
      "https://www.dropbox.com/scl/fi/ycp1lhdbqy9dkouc228te/ink2.png?rlkey=tnck4k1qqgxsnd0wneipszekr&st=frs9fqa7&raw=1"
    ]
  },
  {
    "id": 9,
    "title": "Center for AI and Culture",
    "description": "2021. A freelance project involving the creation of a prototype website for The Center for AI and Culture at NYU Shanghai. This platform serves as a hub for designers, engineers, and theorists to explore AI developments. Additionally, it acts as a content management system for faculty essays. The project was co-founded by Prof. Benjamin Bratton.",
    "type": "work",
    "year": "2021",
    "images": [
      "https://www.dropbox.com/scl/fi/sltjnc89mc6qqcbx5eu56/aic.png?rlkey=z604xmbofuini5qhpqqhmg9hn&st=0bbiei73&raw=1",
      "https://www.dropbox.com/scl/fi/azvg44j5fijpj8mwauib7/aic2.png?rlkey=7vhzqc4i7rhyjbrxsvsty8b9l&st=vsm7ruff&raw=1"
    ]
  }
  // {
  //   "id": 10,
  //   "title": "NM WEBDEX",
  //   "description": "2021. This project was part of the community surrounding the NEW MODELS podcast, which delves into the intersection of networked technology and culture. My contribution was creating a digital 'Codex' screensaver showcasing rapidly stacking memes. Developed under the pseudonym @localhost96, this was a collaborative effort with @jarilyn.",
  //   "type": "play",
  //   "year": "2021",
  //   "images": []
  // }
]



class App extends Component {
  render() {
    return (
      <ProjectsContext.Provider value={projectsRaw}>
        <div className="App">
          <Switch>
            <Route exact path="/" component={Home} />
            <Route path="/project" component={SingleProject} />
            <Route component={Home} />
          </Switch>
        </div>
      </ProjectsContext.Provider>
    );
  }
}

export default App;
