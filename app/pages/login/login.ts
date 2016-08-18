import { Component } from '@angular/core';
import { NavController, AlertController, LoadingController } from 'ionic-angular';
import {Http} from "@angular/http";
import 'rxjs/add/operator/map';
import {Page1} from "../page1/page1";
import { Storage, LocalStorage } from 'ionic-angular';

@Component({
  templateUrl: 'build/pages/login/login.html',
})
export class LoginPage {
  data : any;
  constructor(private navCtrl: NavController, private http : Http, private alert :AlertController, private loading : LoadingController ) {
    this.data = {};
    this.data.username = "";
    this.data.password = "";
  }

  login(){
    let username = this.data.username;
    let password = this.data.password;
    let data = JSON.stringify({username, password});
    let link = "http://textkhmer.com/api/newapi.php";

    this.http.post(link,data)
        .subscribe(data=>{
            let loader = this.loading.create({
                content: "Checking ! Please wait...",
                duration: 1000
            });
            loader.present();
          this.navCtrl.setRoot(Page1);
        },error => {
            let alert = this.alert.create({
                title: 'Warning',
                subTitle: 'Wrong Username or Password! Please Try Again !',
                buttons: ['OK']
            });
            alert.present();
        });
  }

}
