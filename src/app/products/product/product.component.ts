import {Component, OnInit} from "@angular/core";
import {Subscription} from "rxjs/Subscription";
import {ProductService} from "../product.service";
import {UserService} from "../../user/user.service";
import {User} from "../../user/user.model";
import {Product} from "../product.model";
import {ActivatedRoute, Router} from "@angular/router";
import {CartService} from "../../cart/cart.service";

@Component({
    selector: 'app-product',
    templateUrl: './product.component.html',
    styleUrls: ['./product.component.css']
})

export class ProductComponent implements OnInit {
    private sub: Subscription;
    token: User;
    product: Product;

    constructor(private _productService: ProductService,
                private _userService: UserService,
                private _cartService: CartService,
                private _route: ActivatedRoute,
                private _router: Router) {
        this.token = JSON.parse(localStorage.getItem('token'));
    }

    ngOnInit() {
        this.sub = this._route.params
            .subscribe(
                params => {
                    let id = +params['id'];
                    this.loadProduct(id);
                }
            );
    }

    ngOnDestroy() {
        this.sub.unsubscribe();
    }

    loadProduct(id: number) {
        this._productService.getProduct(id)
            .subscribe(data => this.product = data);
    }

    addToCart(product_id: number) {
        product_id = parseFloat(product_id.toString());
        this._cartService.addToCart(product_id, 1);
    }

    checkout() {
        this._cartService.checkout();
    }
}
