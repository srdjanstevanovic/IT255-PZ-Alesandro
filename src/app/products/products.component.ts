import {Component, OnInit} from "@angular/core";
import {Product} from "./product.model";
import {ProductService} from "./product.service";
import {UserService} from "../user/user.service";
import {CartService} from "../cart/cart.service";

@Component({
    selector: 'app-products',
    templateUrl: './products.component.html',
    styleUrls: ['./products.component.css']
})
export class ProductsComponent implements OnInit {
    products: Product[];

    constructor(private _productService: ProductService,
                private _cartService: CartService,
                private _userService: UserService) {
    }

    ngOnInit() {
        this.loadProducts();
    }

    loadProducts() {
        this._productService.getProducts()
            .subscribe(
                data => this.products = data
            )
        ;
    }

    addToCart(product_id: number) {
        product_id = parseFloat(product_id.toString());
        this._cartService.addToCart(product_id, 1);
    }

}
