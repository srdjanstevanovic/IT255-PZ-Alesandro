import {NgModule} from "@angular/core";
import {RouterModule} from "@angular/router";
import {HomeComponent} from "./home/home.component";
import {GalleryComponent} from "./gallery/gallery.component";
import {AboutComponent} from "./about/about.component";
import {UserComponent} from "./user/user.component";
import {ContactComponent} from "./contact/contact.component";
import {CartComponent} from "./cart/cart.component";

@NgModule({
    imports: [
        RouterModule.forRoot(
            [
                {path: 'galerija', component: GalleryComponent},
                {path: 'o-nama', component: AboutComponent},
                {path: 'kontakt', component: ContactComponent},
                {path: 'nalog', component: UserComponent},
                {path: 'korpa', component: CartComponent},
                {path: '', component: HomeComponent}
            ]
        )
    ],
    exports: [RouterModule]
})

export class AppRoutingModule {

}