import {Component, OnInit} from "@angular/core";
import {User} from "./user/user.model";
import {UserService} from "./user/user.service";

@Component({
    selector: 'app-root',
    templateUrl: './app.component.html',
    styleUrls: ['./app.component.css']
})
export class AppComponent implements OnInit {
    token: User;

    constructor(private _userService: UserService) {
        this.token = JSON.parse(localStorage.getItem('token'));
    }

    ngOnInit() {
        if (this.token) {
            this.loadUser();
        }
    }

    loadUser() {
        this._userService.getUser()
            .subscribe(data => this.token = data);
    }

    logout() {
        this._userService.logout();
    }
}
