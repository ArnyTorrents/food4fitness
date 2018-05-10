import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, Routes } from '@angular/router';

import { UserMainComponent } from './../../userApp/components/user-main.component';
import { ReservationMainComponent } from './../../shopApp/components/reservation-main.component';

const appRoutes: Routes = [
  {path:'', redirectTo: '/reservationApp', pathMatch: 'full'},
  {path: 'userApp', component: UserMainComponent},
  {path: 'reservationApp', component: ReservationMainComponent}
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
