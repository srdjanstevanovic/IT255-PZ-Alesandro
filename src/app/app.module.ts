import {BrowserModule} from "@angular/platform-browser";
import {NgModule} from "@angular/core";
import {FormsModule, ReactiveFormsModule} from "@angular/forms";
import {HttpModule} from "@angular/http";

import {AppComponent} from "./app.component";
import {UserComponent} from "./user/user.component";
import {GalleryComponent} from "./gallery/gallery.component";
import {HomeComponent} from "./home/home.component";
import {AboutComponent} from "./about/about.component";
import {CartComponent} from "./cart/cart.component";
import {AppRoutingModule} from "./app-routing.module";
import {UserService} from "./user/user.service";
import {SharedService} from "./shared/shared.service";
import {LoginComponent} from "./user/login/login.component";
import {RegisterComponent} from "./user/register/register.component";
import {ContactComponent} from "./contact/contact.component";
import {ProductService} from "app/products/product.service";
import {ProductsModule} from "./products/products.module";
import {AdminModule} from "./admin/admin.module";

@NgModule({
    imports: [
        BrowserModule,
        FormsModule,
        HttpModule,
        AppRoutingModule,
        ReactiveFormsModule,
        ProductsModule,
        AdminModule
    ],
    declarations: [
        AppComponent,
        UserComponent,
        GalleryComponent,
        HomeComponent,
        AboutComponent,
        CartComponent,
        LoginComponent,
        RegisterComponent,
        ContactComponent
    ],
    providers: [
        UserService,
        SharedService,
        ProductService
    ],
    bootstrap: [AppComponent]
})
export class AppModule {
}
