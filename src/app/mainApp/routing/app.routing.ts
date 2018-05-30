import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, Routes } from '@angular/router';

import { UserMainComponent } from './../../userApp/components/user-main.component';
import { ProductsMainComponent } from './../../shopApp/components/products-main.component';
import { ProductManagmentComponent } from './../../shopApp/components/product-managment.component';

const appRoutes: Routes = [
  {path:'', redirectTo: '/products', pathMatch: 'full'},
  {path: 'userApp', component: UserMainComponent},
  {path: 'shopApp', component: ProductsMainComponent},
  {path: 'products', component: ProductManagmentComponent}
];

@NgModule({
  imports: [
    RouterModule.forRoot(
      appRoutes,
      { enableTracing: false } // <-- debugging purposes only
    )
    // other imports here
  ],
  declarations: [],
  exports: [ RouterModule ]
})
export class AppRoutingModule { }
