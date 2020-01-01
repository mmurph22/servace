import { Injectable } from '@angular/core';

@Injectable()
export class DbConnectionService {

    constructor() { }

    getDbConnectionData = () => {
        let data = {
            //server urls
            "remoteBaseUrl": "http://129.2.24.226:8080/mps/mmurph22/geog650/Final/",
            "localBaseUrl": "http://localhost/650F/",
            "testBaseUrl": "http://129.2.24.226:8080/mps/mmurph22/geog650/Lab3/",
            "PhpSuffix": ".php",
            "ImageCardPath": "../../assets/imgs/cards/",
            "ImagePokerPath": "../../assets/imgs/",

            // put all php command names here
            "getTest": "profile_get",
            "getTest2": "profilehistory_get",
            "setTest": "insert_collision",
            "getProfilePhp": "profile_get",
            "getProfileHistoryPhp": "profilehistory_get",
            "getOpportunitiesPhp": "opportunities_get",
            "getEventSignupPhp": "event_signup_get",
            "setEventSignupPhp": "event_signup_set",
            "getBookingsPhp": "bookings_get",
            "setVolunteersPhp": "volunteer_set",
            "setCoordinatorsPhp": "coordinator_set",
            "getVenuePhp": "venue_get",
            "getVenueHistoryPhp": "venuehistory_get",
            "setEventPhp": "event_set",
            "getEventVolunteersPhp": "eventvols_get",
            "setVolunteersRatingsPhp": "volratings_set",
            "getLoginPhp": "login_get",
            "getUserInfoPhp": "userinfo_get"
        };
        return data;
    };

    getPhpCommand(phpCommand: string) {
        let connection = this.getDbConnectionData();
        let url = connection['remoteBaseUrl'] + connection[phpCommand] + connection['PhpSuffix'];
        return url;
    }
}
