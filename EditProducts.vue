<template>
    <ion-page>
      <ion-header :translucent="true">
        <ion-toolbar>
          <ion-buttons slot="start">
            <ion-back-button default-href="/home"></ion-back-button>
          </ion-buttons>
          <ion-title>Edit Product</ion-title>
        </ion-toolbar>
      </ion-header>
  
      <ion-content :fullscreen="true">
        <ion-header collapse="condense">
          <ion-toolbar>
            <ion-title size="large">Edit Product</ion-title>
          </ion-toolbar>
        </ion-header>
  
        <ion-list lines="none">

            <ion-item>
            <ion-input
              v-model="products.name"
              label="Product Name"
              label-placement="floating"
              placeholder="Enter product name"
            ></ion-input>
          </ion-item>
          <ion-item>
            <ion-textarea
              v-model="products.description"
              label="Product Description"
              label-placement="floating"
              placeholder="Enter product description"
            ></ion-textarea>
          </ion-item>
  
          <ion-item>
            <ion-input
              v-model="products.price"
              label="Product Price"
              label-placement="floating"
              placeholder="Enter product price"
            ></ion-input>
          </ion-item>

          <ion-item>
            <ion-input
              v-model="products.quantity"
              label="Product Quantity"
              label-placement="floating"
              placeholder="Enter product quantity"
            ></ion-input>
          </ion-item>

          <ion-item>
            <input
              type="file"
              accept="image/*"
              @change="onFileChange"
              style="width: 100%; padding: 10px;"
            />
          </ion-item>
  
          <ion-button @click="update">Update Record</ion-button>
          <ion-button color="light" @click="cancel">Cancel</ion-button>
        </ion-list>
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
    IonList,
    IonItem,
    IonInput,
    IonButtons,
    IonBackButton,
  } from "@ionic/vue";
  import axios from "axios";
  import { api } from "../global";
  import { onMounted, reactive } from "vue";
  import { useRoute, useRouter } from "vue-router";
  
  const route = useRoute();
  const router = useRouter();
  
  const products = reactive({
    id: "",
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
            
          products.id = response.data.id;
            products.name = response.data.name;
            products.description = response.data.description;
            products.price = response.data.price;
            products.quantity = response.data.quantity;
            products.image = response.data.image;
          
        }
      })
      .catch(() => {
        console.log("error");
      });
  };
  
  const cancel = async () => {
    router.push("/home");
  };
  
  const onFileChange = (event: Event) => {
    const file = (event.target as HTMLInputElement).files?.[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = () => {
        products.image = reader.result as string;
      };
      reader.readAsDataURL(file);
    }
  };

  const update = () => {
    axios
      .put(api + `/products.php`, products, {
        headers: { "Content-Type": "application/json" },
      })
      .then((response) => {
        if (response.status == 200) {
          router.push("/sellerhome");
        }
      })
      .catch(() => {
        console.log("error");
      });
  };
  
  onMounted(() => {
    viewrecord();
  });
  </script>
  