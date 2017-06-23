import {Component, OnInit} from "@angular/core";
import {CartService} from "./cart.service";
import {Product} from "../products/product.model";
import {TimerObservable} from "rxjs/observable/TimerObservable";
import {Router} from "@angular/router";

@Component({
    selector: 'app-cart',
    templateUrl: './cart.component.html',
    styleUrls: ['./cart.component.css']
})
export class CartComponent implements OnInit {
    cart: Product[];
    totalPrice: number = 0;
    isDone: boolean = false;

    constructor(private _cartService: CartService,
                private _router: Router) {
    }

    ngOnInit() {
        this.loadCart();
    }

    loadCart() {
        this._cartService.getCart()
            .subscribe(data => {
                this.cart = data
            });
    }

    remove(product_id: number) {
        this._cartService.removeFromCart(product_id);
    }

    checkout() {
        this.isDone = true;
        this._cartService.checkout();
        let timer = TimerObservable.create(1000, 500);
        timer.subscribe(t => {
            location.reload();
            this._router.navigate(['/korpa']);
        });
    }

    update(product_id: number, quantity: number) {
        this._cartService.updateInCart(product_id, quantity);
    }

    getTotal() {
        let total = 0;
        for (var i = 0; i < this.cart.length; i++) {
            if (this.cart[i].price) {
                total += this.cart[i].price * this.cart[i].quantity;
                this.totalPrice = total;
            }
        }
        return total;
    }

}
