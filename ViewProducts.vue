<template>
    <ion-page>
      <ion-header :translucent="true">
        <ion-toolbar>
          <ion-buttons slot="start">
            <ion-back-button default-href="/home"></ion-back-button>
          </ion-buttons>
          <ion-title>Product Details</ion-title>
        </ion-toolbar>
      </ion-header>
  
      <ion-content :fullscreen="true">
        <ion-header collapse="condense">
          <ion-toolbar>
            <ion-title size="large">Product Details</ion-title>
          </ion-toolbar>
        </ion-header>
  
        <ion-card>
          <ion-card-content>
            
            <ion-item>
              <ion-text>Name: </ion-text>
              <ion-label
                ><b>{{ products.name }}</b></ion-label
              >
            </ion-item>

            <ion-item>
              <ion-text>Description: </ion-text>
              <ion-label
                ><b>{{ products.description}}</b></ion-label
              >
            </ion-item>

  
            <ion-item>
              <ion-text>Price: </ion-text>
              <ion-label
                ><b>{{ products.price }}</b></ion-label
              >
            </ion-item>

            <ion-item>
              <ion-text>Quantity: </ion-text>
              <ion-label
                ><b>{{ products.quantity }}</b></ion-label
              >
            </ion-item>

            <ion-item>
              <ion-text>Image: </ion-text>
              <ion-label
                ><b> {{ products.image }}</b></ion-label
              >
            </ion-item>
  
            <ion-button @click="update">Edit Record</ion-button>
            <ion-button color="danger" @click="delete_record"
              >Delete Record</ion-button
            >
          </ion-card-content>
        </ion-card>
      </ion-content>
    </ion-page>
  </template>
  
  <script setup lang="ts">
  import {
    IonContent,
    IonHeader,
    IonPage,
    IonTitle,
    IonToolbar,
    IonItem,
    alertController,
    IonButtons,
    IonBackButton,
    IonCard,
    IonCardContent,
  } from "@ionic/vue";
  import axios from "axios";
  import { api } from "../global";
  import { onMounted, reactive } from "vue";
  import { useRoute, useRouter } from "vue-router";
  
  const route = useRoute();
  const router = useRouter();
  
  const products= reactive({
   
    name: "",
    description: "",
    price: "",
    quantity: "",
    image: "",
  });
  
  const viewrecord = () => {
    axios
      .get(api + `/products.php?id=${route.params.id}`)
      .then((response) => {
        if (response.status == 200) {
            products.name = response.data.name;
          products.description = response.data.description;
          products.price = response.data.price;
            products.quantity = response.data.quantity;
            products.image = response.data.image;
          
          console.log(response.data);
        }
      })
      .catch(() => {
        console.log("error");
      });
  };
  
  const delete_record = async () => {
    const alert = await alertController.create({
      header: "Delete",
      message: "Are you sure you want to delete this record?",
      buttons: [
        {
          text: "No",
          role: "cancel",
        },
        {
          text: "Yes",
          handler: () => {
            axios
              .delete(api + `/products.php`, {
                headers: {
                  "Content-Type": "application/json",
                },
                data: { id: route.params.id },
              })
              .then((response) => {
                if (response.status == 200) {
                  router.push("/sellerhome");
                }
              })
              .catch(() => {
                console.log("error");
              });
          },
        },
      ],
    });
  
    await alert.present();
  };
  
  const update = () => {
    router.push(`/EditProducts/${route.params.id}`);
  };
  
  onMounted(() => {
    viewrecord();
  });
  </script>
  