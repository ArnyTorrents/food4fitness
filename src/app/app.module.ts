import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import {FormsModule} from '@angular/forms'

//Server access
import { HttpClientModule } from '@angular/common/http';

//All the dependencies must be imported here
//DatePicker
import { NgxMyDatePickerModule } from 'ngx-mydatepicker';

//All your components must be imported here
//mainApp
import {AppComponent} from './mainApp/components/app.component';

//userApp
import {UserMainComponent} from './userApp/components/user-main.component';
import {UserLoginComponent} from './userApp/components/user-login.component';
import {UserManagementComponent} from './userApp/components/user-management.component';
import {UsersCrudComponent} from './userApp/components/user-crud.component';

//ShopApp

import { ReservationMainComponent } from './shopApp/components/reservation-main.component';
import { ProductsMainComponent } from './shopApp/components/products-main.component'
import { ProductManagmentComponent } from './shopApp/components/product-managment.component';
import { ProductDetailComponent } from './shopApp/components/product-detail.component';

//Pagination
import {NgxPaginationModule} from 'ngx-pagination';

//Directives
import { InputValidationDirective } from './shopApp/directives/input-validation.directive';

//Currency mask
import { CurrencyMaskModule } from "ng2-currency-mask";

//Cookies Magagement
import { CookieService } from 'ngx-cookie-service';

//Routing
import {AppRoutingModule} from './mainApp/routing/app.routing';


@NgModule({
  declarations: [
    AppComponent,
    UserMainComponent,
    UserLoginComponent,
    UserManagementComponent,
    UsersCrudComponent,
    ReservationMainComponent,
    InputValidationDirective,
    ProductsMainComponent,
    ProductManagmentComponent,
    ProductDetailComponent,

  ],
  imports: [
    BrowserModule,
    FormsModule,
    NgxMyDatePickerModule.forRoot(),
    CurrencyMaskModule,
    NgxPaginationModule,
    AppRoutingModule,
    HttpClientModule
  ],
  providers: [CookieService],
  bootstrap: [AppComponent]
})
export class AppModule { }
