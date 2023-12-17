import React, { Component } from "react";
import { Routes, Route, Link } from "react-router-dom";
import "bootstrap/dist/css/bootstrap.min.css";
import "./App.css";

import AddEvent from "./component/add-event.component";
import Event from "./component/event.component";
import EventsList from "./component/events-list.component";

class App extends Component {
  render() {
    return (
      <div>
        <nav className="navbar navbar-expand navbar-dark bg-dark">
          <Link to={"/events"} className="navbar-brand">
            bezKoder
          </Link>
          <div className="navbar-nav mr-auto">
            <li className="nav-item">
              <Link to={"/events"} className="nav-link">
                Events
              </Link>
            </li>
            <li className="nav-item">
              <Link to={"/add"} className="nav-link">
                Add
              </Link>
            </li>
          </div>
        </nav>

        <div className="container mt-3">
          <Routes>
            <Route path="/" element={<EventsList/>} />
            <Route path="/events" element={<EventsList/>} />
            <Route path="/add" element={<AddEvent/>} />
            <Route path="/event/:id" element={<Event/>} />
          </Routes>
        </div>
      </div>
    );
  }
}

export default App;