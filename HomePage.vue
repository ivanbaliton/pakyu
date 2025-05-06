<template>
  <ion-page>
    <ion-header>
      <ion-toolbar>
      <ion-title>Products</ion-title>
      <ion-buttons slot="end">
        <ion-button @click="isModalOpen = true" style="padding: 0; border-radius: 50%; width: 40px; height: 40px; overflow: hidden;">
        <ion-avatar style="width: 100%; height: 100%;">
          <img src="https:" alt="Profile">
        </ion-avatar>
        </ion-button>
      </ion-buttons>
      </ion-toolbar>
    </ion-header>

    <ion-modal :is-open="isModalOpen" @didDismiss="isModalOpen = false">
      <ion-header>
      <ion-toolbar>
        <ion-title>User Mode</ion-title>
        <ion-buttons slot="end">
        <ion-button @click="isModalOpen = false">Close</ion-button>
        </ion-buttons>
      </ion-toolbar>
      </ion-header>
      <ion-content>
      <ion-list>
        <ion-item button @click="NavigateToHome">Buyer</ion-item>
        <ion-item button @click="NavigateToSellerHome">Become a Seller</ion-item>
        
      </ion-list>
      </ion-content>
    </ion-modal>

  
  <ion-content>
    <ion-grid>
      <ion-row>
        <ion-col size="4" v-for="product in products" :key="product.id">
          <ion-card>
            <img 
              :src="product.image_path" 
              alt="Product Image" 
              
              style="width: 100%; height: 200px; object-fit: cover;"/>
            <ion-card-header>
              <ion-card-title class="product-title">{{ product.name }}</ion-card-title>
              <ion-card-subtitle class="product-price">${{ product.price }}</ion-card-subtitle>
            </ion-card-header>
            <ion-card-content>
              <ion-button expand="block" size="small">Add</ion-button>
            </ion-card-content>
          </ion-card>
        </ion-col>
      </ion-row>
    </ion-grid>
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
  IonGrid, 
  IonRow, 
  IonCol, 
  IonCard, 
  IonImg, 
  IonCardHeader, 
  IonCardTitle, 
  IonCardSubtitle, 
  IonCardContent,  
  IonModal, 
  IonAvatar, 
  IonButtons, 
  IonButton, 
  IonFab, 
  IonFabButton, 
  IonIcon 
} from '@ionic/vue';

import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
import { api } from "../global";

import axios from 'axios'

const router = useRouter();
const isModalOpen = ref(false);

const products = ref<
  {

    id: number;
    name: string;
    description: string;
    price: number;
    quantity: number;
    image_path: string
    
  }[]
>();

function fetchProducts() {
  axios
    .get(api + '/products.php')
    .then((response) => {
      products.value = response.data;
    })
    .catch(() => {
      console.log('error');
    });
}

function NavigateToHome() {
  
  router.push('/home');
  isModalOpen.value = false
}

function NavigateToSellerHome() {
  router.push('/sellerhome');
  isModalOpen.value = false
}





onMounted(() => {
  fetchProducts();
});


</script>

<style scoped>
.product-title {
  font-size: 1.2rem;
  font-weight: bold;
}
.product-price {
  color: #888;
}
</style>
