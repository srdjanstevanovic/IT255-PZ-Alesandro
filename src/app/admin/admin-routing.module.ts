import {RouterModule} from "@angular/router";
import {AdminComponent} from "./admin.component";
import {NgModule} from "@angular/core";


@NgModule({
    imports: [
        RouterModule.forChild([
            {path: 'admin', component: AdminComponent}
        ])
    ],
    exports: [RouterModule]
})

export class AdminRoutingModule {

}