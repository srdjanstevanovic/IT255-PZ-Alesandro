import {Component, OnInit} from "@angular/core";
import {User} from "../user.model";
import {UserService} from "../user.service";
import {TimerObservable} from "rxjs/observable/TimerObservable";
import {Router} from "@angular/router";
import {City} from "../city";

@Component({
    selector: 'app-register',
    templateUrl: './register.component.html',
    styleUrls: ['./register.component.css']
})
export class RegisterComponent implements OnInit {
    token: User;
    cities: City[];
    model: any = {};
    loading: boolean = false;

    constructor(private _userService: UserService,
                private _router: Router) {
        this.token = JSON.parse(localStorage.getItem('token'));
    }

    ngOnInit() {
        this.loadCities();
    }

    loadCities() {
        this._userService.getCities()
            .subscribe(data => this.cities = data);
    }

    register() {
        this.loading = true;
        this._userService.register(this.model.mail,
            this.model.password,
            this.model.address,
            this.model.city_id,
            this.model.tin)
            .subscribe(
                data => {
                    let timer = TimerObservable.create(1500, 100);
                    timer.subscribe(t => {
                        location.reload();
                        this._router.navigate(['']);
                    });
                }
            )
        ;
    }

}
