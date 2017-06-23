import {Component, OnInit} from "@angular/core";
import {Router} from "@angular/router";
import {UserService} from "app/user/user.service";
import {User} from "app/user/user.model";
import {TimerObservable} from "rxjs/observable/TimerObservable";

@Component({
    selector: 'app-login',
    templateUrl: './login.component.html',
    styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit {
    token: User;
    model: any = {};
    loading: boolean = false;

    constructor(private _userService: UserService,
                private _router: Router) {
        this.token = JSON.parse(localStorage.getItem('token'));
    }

    ngOnInit() {
    }


    login() {
        this.loading = true;
        this._userService.login(this.model.mail, this.model.password)
            .subscribe(
                data => {
                    let timer = TimerObservable.create(1000, 500);
                    timer.subscribe(t => {
                        location.reload();
                        this._router.navigate(['']);
                    });
                }
            );
    }

}
