import {Injectable} from "@angular/core";
import {Http, Response} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {User} from "./user.model";
import {SharedService} from "../shared/shared.service";
import "rxjs/add/operator/map";
import {City} from "./city";
import {TimerObservable} from "rxjs/observable/TimerObservable";

@Injectable()
export class UserService {
    private _base = 'http://127.0.0.1/alesandro-api/users/';

    constructor(private _http: Http,
                private _sharedService: SharedService) {
    }

    getUser(): Observable<User> {
        let headers = this._sharedService.getHeaders();
        return this._http.get(this._base + 'get.php', {headers: headers})
            .map((response: Response) => <User> response.json());
    }

    register(mail: string, password: string, address: string, city_id: number, tin: number) {
        let data = "mail=" + mail + "&password=" + password + "&address="
            + address + "&city_id=" + city_id + "&tin=" + tin;
        let headers = this._sharedService.getHeaders();
        return this._http.post(this._base + 'register.php', data, {headers: headers})
            .map((response: Response) => {
                    let user = response.json();
                    if (user && user.token) {
                        localStorage.setItem('token', JSON.stringify(user.token));
                    }
                }
            );
    }

    login(mail: string, password: string) {
        let data = "mail=" + mail + "&password=" + password;
        let headers = this._sharedService.getHeaders();
        return this._http.post(this._base + 'login.php', data, {headers: headers})
            .map((response: Response) => {
                    let user = response.json();
                    if (user && user.token) {
                        localStorage.setItem('token', JSON.stringify(user.token));
                    }
                }
            );
    }

    getCities(): Observable<City[]> {
        return this._http.get(this._base + 'city.php')
            .map((response: Response) => <City[]> response.json());
    }

    logout() {
        localStorage.removeItem('token');
        let timer = TimerObservable.create(1000, 500);
        timer.subscribe(t => {
            location.reload();
        });
    }

}
