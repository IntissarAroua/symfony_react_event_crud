import http from "../http-common";

class TutorialDataService {
    getAll() {
        return http.get("/event");
    }

    get(id) {
        return http.get(`/event/${id}/detail`);
    }

    create(data) {
        return http.post("/event/add", data);
    }

    update(id, data) {
        return http.put(`/event/${id}/edit`, data);
    }

    delete(id) {
        return http.delete(`/event/${id}/delete`);
    }

    // findByTitle(title) {
    //     return http.get(`/tutorials?title=${title}`);
    // }
}

export default new TutorialDataService();