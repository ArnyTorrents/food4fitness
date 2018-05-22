import { Component, OnInit,ViewChild,
  Input, Output, EventEmitter  } from '@angular/core';
import { Router } from '@angular/router';

//Model
import { Comanda } from "./../model/comanda";
import { ComandaProducts} from "./../model/comanda-products";
import { Products } from './../model/products';
import { ProductType} from './../model/productType';
import { User } from './../model/user';

//Service
import { ProductDataService } from './../services/product-data.service';

//Cookie
import { CookieService } from 'ngx-cookie-service';

@Component({
  selector: 'product-detail',
  templateUrl: './../views/product-detail.view.html',
  styleUrls: ['./../css/product-detail.style.css'],
  providers: [ProductDataService]
})
export class ProductDetailComponent implements OnInit {

  pageTitle: string = 'Product Detail';
  shopAction: number;
  errorMessage: string;
  roleUser: string;


  @Input() productDetail : Products;
  @Input() productsType : ProductType[];

  // We'll use
  //setShopAction.emit(variable Content to comunicate)
  @Output() setShopAction:EventEmitter<number>
              = new EventEmitter<number>();

  constructor(private router: Router,
              private productDataService: ProductDataService,
              private cookieService: CookieService) { }

  ngOnInit() {
    if(this.cookieService.check("user")){
      let cookieObj:any =
            JSON.parse(this.cookieService.get("user"));
      let userConnected = new User();
      Object.assign(userConnected,cookieObj);
      this.roleUser = cookieObj.role;
    }else{
      console.log("No cookie created")
    }

  }

  productMangment() : void {

  }

  setShopActionDetail(action:number): void {
    this.shopAction=action;
  }
}
