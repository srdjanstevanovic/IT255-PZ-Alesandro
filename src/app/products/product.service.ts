import {Injectable} from "@angular/core";
import {Observable} from "rxjs/Observable";
import {Product} from "./product.model";
import {Http, Response} from "@angular/http";

import "rxjs/add/operator/map";
import "rxjs/add/operator/do";
import "rxjs/add/operator/catch";
import {SharedService} from "../shared/shared.service";
import {Element} from "./product/element.model";

@Injectable()
export class ProductService {
    private _base = 'http://127.0.0.1/alesandro-api/products/';

    constructor(private _http: Http,
                private _sharedService: SharedService) {
    }

    addProduct(name: number, type_id: string, elements_number: number,
               code: number, price: number, image: string) {
        let data = '';
        let headers = this._sharedService.getHeaders();
        this._http.post(this._base + 'add.php', data, {headers: headers})
            .map(res => res)
            .subscribe(data => data)
    }

    getProducts(): Observable<Product[]> {
        return this._http.get(this._base + 'get.php')
            .map((response: Response) => <Product[]> response.json().products);
    }

    getProduct(id: number): Observable<Product> {
        return this.getProducts()
            .map((products: Product[]) => products.find(p => p.id === id));
    }

    removeProduct(product_id: number) {
        let data = 'id=' + product_id;
        let headers = this._sharedService.getHeaders();
        this._http.post(this._base + 'remove.php', data, {headers: headers})
            .map(res => res)
            .subscribe(data => data)
    }

    getElements(): Observable<Element[]> {
        return this._http.get(this._base + 'elements.php')
            .map((response: Response) => <Element[]> response.json());
    }

    getTypes(): Observable<any[]> {
        return this._http.get(this._base + 'types.php')
            .map((response: Response) => <any[]> response.json());
    }
}
