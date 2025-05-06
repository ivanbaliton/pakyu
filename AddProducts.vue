<template>
    <ion-page>
        <ion-header :translucent="true">
            <ion-toolbar>
                <ion-title>Add Product</ion-title>
            </ion-toolbar>
        </ion-header>

        <ion-content :fullscreen="true">
            <ion-header collapse="condense">
                <ion-toolbar>
                    <ion-title size="large"></ion-title>
                </ion-toolbar>
            </ion-header>

            <ion-list lines="none">
                <ion-item>
                    <ion-input
                        v-model="product.name"
                        label="Product Name"
                        label-placement="floating"
                        placeholder="Enter product name"
                    ></ion-input>
                </ion-item>

                <ion-item>
                    <ion-textarea
                        v-model="product.description"
                        label="Product Description"
                        label-placement="floating"
                        placeholder="Enter product description"
                       
                    ></ion-textarea>
                </ion-item>

                <ion-item>
                    <ion-input
                        v-model="product.price"
                        label="Price"
                        label-placement="floating"
                        placeholder="Enter price"
                        type="number"
                    ></ion-input>
                </ion-item>

                <ion-item>
                    <ion-input
                        v-model="product.quantity"
                        label="Quantity"
                        label-placement="floating"
                        placeholder="Enter quantity"
                        type="number"
                    ></ion-input>
                </ion-item>

                <ion-item>
                    <label for="file-upload" class="file-upload-label"></label>
                    <input
                        id="file-upload"
                        type="file"
                        accept="image/*"
                        @change="onFileChange"
                        class="file-upload-input"
                    />
                </ion-item>

                <ion-button expand="block" @click="save">Save Product</ion-button>
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
    IonTextarea,
    IonButton,
} from "@ionic/vue";

import axios from "axios";
import { api } from "../global";
import { reactive } from "vue";
import { useRouter } from "vue-router";

const router = useRouter();

const product = reactive({
    name: "",
    description: "",
    price: "",
    quantity: "",
    image_path: "",
});

const onFileChange = (event: Event) => {
    const file = (event.target as HTMLInputElement).files?.[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = () => {
            product.image_path = reader.result as string;
        };
        reader.readAsDataURL(file);
    }
};

const save = () => {
    axios
        .post(api + "/products.php", product, {
            headers: { "Content-Type": "application/json" },
        })
        .then((response) => {
            if (response.status == 200) {
                router.push("/sellerhome");
            }
        })
        .catch((error) => {
            console.log(error);
        });
};
</script>
