import React, { Component } from "react";
import EventDataService from "../service/event.service";

export default class AddEvent extends Component {
  constructor(props) {
    super(props);
    this.onChangeTitle = this.onChangeTitle.bind(this);
    this.onChangeDescription = this.onChangeDescription.bind(this);
    this.onChangeStartDate = this.onChangeStartDate.bind(this);
    this.onChangeEndDate = this.onChangeEndDate.bind(this);
    this.onChangeLocation = this.onChangeLocation.bind(this);

    this.saveEvent = this.saveEvent.bind(this);
    this.newEvent = this.newEvent.bind(this);

    this.state = {
      id: null,
      title: "",
      description: "",
      start_date: `${new Date().getFullYear()}-${`${new Date().getMonth() +
        1}`.padStart(2, 0)}-${`${new Date().getDate()}`.padStart(
          2,
          0
        )}T${`${new Date().getHours()}`.padStart(
          2,
          0
        )}:${`${new Date().getMinutes()}`.padStart(2, 0)}`,
      end_date: `${new Date().getFullYear()}-${`${new Date().getMonth() +
        1}`.padStart(2, 0)}-${`${new Date().getDate()}`.padStart(
          2,
          0
        )}T${`${new Date().getHours()}`.padStart(
          2,
          0
        )}:${`${new Date().getMinutes()}`.padStart(2, 0)}`,
      location: "",

      submitted: false
    };
  }

  onChangeTitle(e) { this.setState({ title: e.target.value }); }
  onChangeDescription(e) { this.setState({ description: e.target.value }); }
  onChangeStartDate(e) { this.setState({ start_date: e.target.value }); }
  onChangeEndDate(e) { this.setState({ end_date: e.target.value }); }
  onChangeLocation(e) { this.setState({ location: e.target.value }); }

  saveEvent() {
    var data = {
      title: this.state.title,
      description: this.state.description,
      start_date: this.state.start_date,
      end_date: this.state.end_date,
      location: this.state.location
    };

    EventDataService.create(data)
      .then(response => {
        this.setState({
          id: response.data.id,
          title: response.data.title,
          description: response.data.description,
          start_date: response.data.start_date,
          end_date: response.data.end_date,
          location: response.data.location,

          submitted: true
        });
        console.log(response.data);
      })
      .catch(e => {
        console.log(e);
      });
  }

  newEvent() {
    this.setState({
      id: null,
      title: "",
      description: "",
      start_date: `${new Date().getFullYear()}-${`${new Date().getMonth() +
        1}`.padStart(2, 0)}-${`${new Date().getDate()}`.padStart(
          2,
          0
        )}T${`${new Date().getHours()}`.padStart(
          2,
          0
        )}:${`${new Date().getMinutes()}`.padStart(2, 0)}`,
      end_date: `${new Date().getFullYear()}-${`${new Date().getMonth() +
        1}`.padStart(2, 0)}-${`${new Date().getDate()}`.padStart(
          2,
          0
        )}T${`${new Date().getHours()}`.padStart(
          2,
          0
        )}:${`${new Date().getMinutes()}`.padStart(2, 0)}`,
      location: "",

      submitted: false
    });
  }

  render() {
    return (
      <div className="submit-form">
        {this.state.submitted ? (
          <div>
            <h4>You submitted successfully!</h4>
            <button className="btn btn-success" onClick={this.newEvent}>
              Add
            </button>
          </div>
        ) : (
          <div>
            <div className="form-group">
              <label htmlFor="title">Titre</label>
              <input
                type="text"
                className="form-control"
                id="title"
                required
                value={this.state.title}
                onChange={this.onChangeTitle}
                name="title"
              />
            </div>

            <div className="form-group">
              <label htmlFor="description">Description</label>
              <textarea
                className="form-control"
                id="description"
                required
                value={this.state.description}
                onChange={this.onChangeDescription}
                name="description"
              ></textarea>
            </div>

            <div className="form-group">
              <label htmlFor="start_date">De ..</label>
              <input
                type="datetime-local"
                className="form-control"
                id="start_date"
                required
                value={this.state.start_date}
                onChange={this.onChangeStartDate}
                name="start_date"
              />
            </div>

            <div className="form-group">
              <label htmlFor="end_date">à ..</label>
              <input
                type="datetime-local"
                className="form-control"
                id="end_date"
                required
                value={this.state.end_date}
                onChange={this.onChangeEndDate}
                name="end_date"
              />
            </div>

            <div className="form-group">
              <label htmlFor="location">Lieu</label>
              <input
                type="text"
                className="form-control"
                id="location"
                required
                value={this.state.location}
                onChange={this.onChangeLocation}
                name="location"
              />
            </div>

            <button onClick={this.saveEvent} className="btn btn-success">
              Enregistrer
            </button>
          </div>
        )}
      </div>
    );
  }
}