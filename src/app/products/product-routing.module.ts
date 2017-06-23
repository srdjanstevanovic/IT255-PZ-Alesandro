import {NgModule} from "@angular/core";
import {RouterModule} from "@angular/router";
import {ProductComponent} from "./product/product.component";
import {ProductsComponent} from "app/products/products.component";

@NgModule({
    imports: [
        RouterModule.forChild([
            {path: 'kockaline', component: ProductsComponent},
            {path: 'kockaline/:id', component: ProductComponent}
        ])
    ],
    exports: [RouterModule]
})

export class ProductRoutingModule {
}