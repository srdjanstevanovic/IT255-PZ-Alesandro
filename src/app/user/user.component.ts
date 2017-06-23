import {Component, OnInit} from "@angular/core";
import {UserService} from "./user.service";
import {User} from "./user.model";

@Component({
    selector: 'app-user',
    templateUrl: './user.component.html',
    styleUrls: ['./user.component.css']
})
export class UserComponent implements OnInit {
    token: User;

    constructor(private _userService: UserService) {
        this.token = JSON.parse(localStorage.getItem('token'));
    }

    ngOnInit() {
    }

    logout() {
        this._userService.logout();
    }

}
