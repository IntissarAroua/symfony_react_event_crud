import React, { Component } from "react";
import EventDataService from "../service/event.service";
import { withRouter } from '../common/with-router';

class Event extends Component {
    constructor(props) {
        super(props);
        this.onChangeTitle = this.onChangeTitle.bind(this);
        this.onChangeDescription = this.onChangeDescription.bind(this);
        this.onChangeStartDate = this.onChangeStartDate.bind(this);
        this.onChangeEndDate = this.onChangeEndDate.bind(this);
        this.onChangeLocation = this.onChangeLocation.bind(this);

        this.getEvent = this.getEvent.bind(this);
        this.updateEvent = this.updateEvent.bind(this);
        this.deleteEvent = this.deleteEvent.bind(this);

        this.state = {
            currentEvent: {
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
                location: ""
            },
            message: ""
        };
    }

    componentDidMount() {
        this.getEvent(this.props.router.params.id);
    }

    onChangeTitle(e) {
        const title = e.target.value;

        this.setState(function (prevState) {
            return {
                currentEvent: {
                    ...prevState.currentEvent,
                    title: title
                }
            };
        });
    }
    onChangeDescription(e) {
        const description = e.target.value;

        this.setState(prevState => ({
            currentEvent: {
                ...prevState.currentEvent,
                description: description
            }
        }));
    }
    onChangeStartDate(e) {
        const start_date = e.target.value;

        this.setState(prevState => ({
            currentEvent: {
                ...prevState.currentEvent,
                start_date: start_date
            }
        }));
    }
    onChangeEndDate(e) {
        const end_date = e.target.value;

        this.setState(prevState => ({
            currentEvent: {
                ...prevState.currentEvent,
                end_date: end_date
            }
        }));
    }
    onChangeLocation(e) {
        const location = e.target.value;

        this.setState(prevState => ({
            currentEvent: {
                ...prevState.currentEvent,
                location: location
            }
        }));
    }


    getEvent(id) {
        EventDataService.get(id)
            .then(response => {
                this.setState({
                    currentEvent: response.data
                });
                console.log(response.data);
            })
            .catch(e => {
                console.log(e);
            });
    }

    updateEvent() {
        EventDataService.update(
            this.state.currentEvent.id,
            this.state.currentEvent
        )
            .then(response => {
                console.log(response.data);
                this.setState({
                    message: "The event was updated successfully!"
                });
            })
            .catch(e => {
                console.log(e);
            });
    }

    deleteEvent() {
        EventDataService.delete(this.state.currentEvent.id)
            .then(response => {
                console.log(response.data);
                this.props.router.navigate('/events');
            })
            .catch(e => {
                console.log(e);
            });
    }

    render() {
        const { currentEvent } = this.state;

        return (
            <div>
                {currentEvent ? (
                    <div className="edit-form">
                        <h4>Event</h4>
                        <form>
                            <div className="form-group">
                                <label htmlFor="title">Title</label>
                                <input
                                    type="text"
                                    className="form-control"
                                    id="title"
                                    value={currentEvent.title}
                                    onChange={this.onChangeTitle}
                                />
                            </div>
                            <div className="form-group">
                                <label htmlFor="description">Description</label>
                                <input
                                    type="text"
                                    className="form-control"
                                    id="description"
                                    value={currentEvent.description}
                                    onChange={this.onChangeDescription}
                                />
                            </div>
                            <div className="form-group">
                                <label htmlFor="start_date">De ..</label>
                                <input
                                    type="datetime-local"
                                    className="form-control"
                                    id="start_date"
                                    value={currentEvent.start_date}
                                    onChange={this.onChangeStartDate}
                                />
                            </div>
                            <div className="form-group">
                                <label htmlFor="end_date">à ..</label>
                                <input
                                    type="datetime-local"
                                    className="form-control"
                                    id="end_date"
                                    value={currentEvent.end_date}
                                    onChange={this.onChangeEndDate}
                                />
                            </div>
                            <div className="form-group">
                                <label htmlFor="location">Lieu</label>
                                <input
                                    type="text"
                                    className="form-control"
                                    id="location"
                                    value={currentEvent.location}
                                    onChange={this.onChangeLocation}
                                />
                            </div>
                        </form>
                        <button
                            className="btn btn-danger mr-2"
                            onClick={this.deleteEvent}
                        >
                            Delete
                        </button>

                        <button
                            type="submit"
                            className="btn btn-success"
                            onClick={this.updateEvent}
                        >
                            Update
                        </button>
                    </div>
                ) : (
                    <div>
                        <br />
                        <p>Please click on a Event...</p>
                    </div>
                )}
            </div>
        );
    }
}

export default withRouter(Event);
