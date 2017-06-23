import {Injectable} from "@angular/core";
import {Http, Response} from "@angular/http";
import {SharedService} from "../shared/shared.service";
import {Observable} from "rxjs/Observable";
import {Product} from "../products/product.model";

@Injectable()
export class CartService {
    private _base = 'http://127.0.0.1/alesandro-api/orders/';

    constructor(private _http: Http,
                private _sharedService: SharedService) {
    }

    addToCart(product_id: number, quantity: number) {
        let data = "product_id=" + product_id + "&quantity=" + quantity;
        let headers = this._sharedService.getHeaders();
        this._http.post(this._base + 'add.php', data, {headers: headers})
            .map(res => res)
            .subscribe(data => {
                console.log(data)
            })
    }

    removeFromCart(product_id: number) {
        let data = "product_id=" + product_id;
        let headers = this._sharedService.getHeaders();
        this._http.post(this._base + 'remove.php', data, {headers: headers})
            .map(res => res)
            .subscribe(data => data)
    }

    updateInCart(product_id: number, quantity: number) {
        let data = "product_id=" + product_id + "&quantity=" + quantity;
        let headers = this._sharedService.getHeaders();
        this._http.post(this._base + 'update.php', data, {headers: headers})
            .map(res => res)
            .subscribe(data => data)
    }

    checkout() {
        let headers = this._sharedService.getHeaders();
        this._http.get(this._base + 'checkout.php', {headers: headers})
            .map(res => res)
            .subscribe(data => data)
    }

    getCart(): Observable<Product[]> {
        let headers = this._sharedService.getHeaders();
        return this._http.get(this._base + 'get.php', {headers: headers})
            .map((response: Response) => <Product[]> response.json());
    }
}
