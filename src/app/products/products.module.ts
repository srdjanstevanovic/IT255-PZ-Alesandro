import {ProductRoutingModule} from "./product-routing.module";
import {FormsModule} from "@angular/forms";
import {HttpModule} from "@angular/http";
import {BrowserModule} from "@angular/platform-browser";
import {SharedService} from "../shared/shared.service";
import {ProductService} from "app/products/product.service";
import {UserService} from "../user/user.service";
import {ProductsComponent} from "app/products/products.component";
import {ProductComponent} from "./product/product.component";
import {NgModule} from "@angular/core";
import {CartService} from "../cart/cart.service";


@NgModule({
    imports: [
        BrowserModule,
        FormsModule,
        HttpModule,
        ProductRoutingModule
    ],
    declarations: [
        ProductsComponent,
        ProductComponent
    ],
    providers: [
        UserService,
        SharedService,
        ProductService,
        CartService
    ]
})

export class ProductsModule {
}
