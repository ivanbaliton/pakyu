<template>
    <ion-page>
      <ion-header>
        <ion-toolbar>
      <ion-title>Select User Mode</ion-title>
      <ion-buttons slot="end">
        <ion-button @click="isModalOpen = true" style="padding: 0; border-radius: 50%; width: 40px; height: 40px; overflow: hidden;">
        <ion-avatar style="width: 100%; height: 100%;">
          <img src="https://via.placeholder.com/50" alt="Profile">
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
        <ion-list lines="full">
        <ion-item
          :href="`/ViewProducts/${product.id}`"
          v-for="(product, index) in products"
          v-bind:key="product.id"
        >
          <ion-badge slot="start">{{ index + 1 }}</ion-badge>
          <ion-label
            ><h3>
              {{ product.name }}
            </h3>
            <p>{{ product.quantity  }} {{  }}</p></ion-label
          >
        </ion-item>

      </ion-list>

        <ion-fab vertical="bottom" horizontal="end">
            <ion-fab-button href="AddProducts">
                <ion-icon :icon="add"></ion-icon>
            </ion-fab-button>
      </ion-fab>
      </ion-content>
    </ion-page>
  </template>
  
  <script setup lang="ts">
  import { IonContent, IonHeader, IonPage, IonTitle, IonToolbar, IonGrid, IonRow, IonCol, IonCard, IonImg, IonCardHeader, IonCardTitle, IonCardSubtitle, IonCardContent, IonButton } from '@ionic/vue';
  import { onMounted, ref } from 'vue';
  import { useRouter } from 'vue-router';
  import { api } from "../global";
  import { add } from 'ionicons/icons';
  
  import axios from 'axios';
  
  const isModalOpen = ref(false);
  
  const products = ref<
      {
    
        id: number;
        name: string;
        price: number;
        quantity: number;
        image: string
        
      }[]
  >();
  
  function fetchProducts() {
    axios
      .get(api + '/products.php')
      .then((response) => {
        products.value = response.data.map(
        (item: {
          id: number;
          name: string;
          description: string;
          price: number;
        quantity: number;
          image: string
        }) => ({
          id: item.id,
          name: item.name,
          price: item.price,
          quantity: item.quantity,
          image: item.image
          
        }) 
      );
      })
      .catch(() => {
        console.log('error');
      });
  }


  const router = useRouter();
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
  