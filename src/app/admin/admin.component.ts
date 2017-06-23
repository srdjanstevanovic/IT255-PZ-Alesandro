import {Component, OnInit} from "@angular/core";
import {Product} from "../products/product.model";
import {ProductService} from "../products/product.service";
import {Element} from "../products/product/element.model";

@Component({
    selector: 'app-admin',
    templateUrl: './admin.component.html',
    styleUrls: ['./admin.component.css']
})
export class AdminComponent implements OnInit {
    products: Product[];
    elements_number: Element[];
    types: any = {};
    extend: boolean = false;

    constructor(private _productService: ProductService) {
    }

    ngOnInit() {
        this.loadProducts();
    }

    loadProducts() {
        this._productService.getProducts()
            .subscribe(data => {
                this.products = data
            });
    }

    loadTypes() {
        this._productService.getElements()
            .subscribe(data => this.elements_number = data)
    }

    loadElements() {
        this._productService.getElements()
            .subscribe(data => {
                this.types = data;
                console.log(data)
            });
    }

    remove(product_id: number) {
        this._productService.removeProduct(product_id);
    }

    update(product_id: number, quantity: number) {
        // this._productService.update(product_id, quantity);
    }

    add() {
        this.extend = true;
    }
}
