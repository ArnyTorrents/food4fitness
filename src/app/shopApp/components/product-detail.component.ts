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
  //edit: number;
  //new: number;
  product: Products;
  validFile: boolean = false;
  userImageFile: File;
  IdImage:number;


  @Input() productDetail : Products;
  @Input() products : Products[];
  @Input() productsType : ProductType[]=[];


  @Input() edit:number;
  @Input() new:number;
  // We'll use
  //setShopAction.emit(variable Content to comunicate)
  @Output() setShopAction:EventEmitter<number>
              = new EventEmitter<number>();

  constructor(private router: Router,
              private productDataService: ProductDataService,
              private cookieService: CookieService) { }

  ngOnInit() {
    console.log(this.new);

    if(this.new==1){
      let product = new Products();
      this.productDetail = product;
    }
    //this.edit = 0;
    //this.new = 0;
    this.product = new Products();

    if(sessionStorage.getItem('connectedUser')){
      let cookieObj:any =   JSON.parse(sessionStorage.getItem("connectedUser"));
      let userConnected = new User();
      Object.assign(userConnected,cookieObj);
      this.roleUser = cookieObj.role;
    }else{
      console.log("No sessio conectada")
    }


    console.log(this.productsType);

  }

  getFiles(event): void{
    if (event.target.files.length> 0)
    {
      this.userImageFile = event.target.files[0];
      this.validFile = true;
    }
    else {
      this.validFile = false;
    }
  }



  productMangment() : void {

    if(this.new==1){
      console.log(this.productDetail);
      this.productDataService.insertProducts(this.productDetail).subscribe(
        outPutData => {
          if(Array.isArray(outPutData) && outPutData.length > 0)
          {
            if(outPutData[0]=== true)
            {
                    let filesNames : string [] = [];
                    filesNames.push(outPutData[1][0].id);
                    this.IdImage = outPutData[1][0].id;

                    this.productDetail.setId(0);
                    this.productDetail.setImg("Image " + this.IdImage);

                    this.productDataService.uploadFiles(this.userImageFile,filesNames).subscribe(
                    outPutData => {
                      if(Array.isArray(outPutData) && outPutData.length > 0)
                      {
                        if(outPutData[0]=== true)
                        {
                            //We will go again to the server in order to
                            //insert user details in database
                        }
                      } else {
                        alert("There has been an error, try later");
                        console.log("Error in ProductDetailComponent (productMangment NEW - uploadFiles): outPutData is not array"
                                + JSON.stringify(outPutData));
                      }
                    },
                    error => {
                      alert("There has been an error, try later");
                      console.log("Error in ProductDetailComponent (productMangment NEW - uploadFiles): "
                                  +JSON.stringify(error));
                    }
                  );

              alert("Product inserted correctly");
              this.setShopAction.emit(0);

            } else {
              alert("There has been an error, try later");
              console.log("Error in ProductDetailComponent (productMangment NEW): outPutData is false: "
                      + JSON.stringify(outPutData));
              this.router.navigate(["userApp"]);
            }
          } else {
            alert("There has been an error, try later");
            console.log("Error in ProductDetailComponent (productMangment NEW): outPutData is not array"
                    + JSON.stringify(outPutData));
            this.router.navigate(["userApp"]);
          }
        },
        error => {
          alert("There has been an error, try later");
          console.log("Error in Product Detail (productMangment): "
                      +JSON.stringify(error));
          this.router.navigate(["userApp"]);
        }
      );
    }
    else{
      this.productDataService.modifyProducts(this.productDetail).subscribe( outPutData => {
                if(outPutData.length > 0 && Array.isArray(outPutData) && JSON.parse(outPutData[0]) == true) {
                  alert("Product correctly modified");
                  this.setShopAction.emit(0);
                } else {
                  alert("Sorry, there has been an error, try later");
                  console.log("ProductDetailComponent (productMangment, Edit): No reservation times found");
                  this.router.navigate(["userApp"]);
                }
              },
              error => {
                alert("Sorry, there has been an error, try later");
                console.log("ProductDetailComponent (productMangment, Edit). Error happened: " + JSON.stringify(error));
                this.router.navigate(["userApp"]);
              }
        );
    }

  }
  insert() : void {
    this.new = 1;
    this.edit = 0;

    this.productDetail = new Products();
    this.productDetail.setId(0);
    this.productDetail.setImg("Image " + this.IdImage);
    console.log(this.productDetail);


  }
  modify() : void {
    this.new = 0;
    this.edit = 1;
    console.log(this.productDetail);

  }

  nextproduct() : void {
    // this.productDetail = this.products[this.productDetail.id+1];
    console.log(this.products);
    console.log(this.products[this.productDetail.id]);

  }


  setShopActionDetail(action:number): void {
    this.shopAction=action;
  }
}
