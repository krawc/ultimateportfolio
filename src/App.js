import React, { Component } from 'react';
import logo from './logo.svg';
import './App.css';
import { BrowserRouter as Router, Route, Link, Switch, Redirect } from 'react-router-dom';
import Work from './Work.js';
import Home from './Home.js';
import SingleProject from './SingleProject.js';


class App extends Component {
  render() {
    return (
        <div className="App">
          <Switch>
            <Route exact path="/" component={Home} />
            <Route path="/project" component={SingleProject} />
            <Route component={Home} />
          </Switch>
        </div>
    );
  }
}

export default App;
