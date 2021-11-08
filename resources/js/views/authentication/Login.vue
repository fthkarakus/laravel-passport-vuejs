<template>
    <div class="container">
        <div class="card card-login mx-auto mt-5">
            <div class="card-header">Öğrenci Bilgi Sistemi Kullanıcı Girişi</div>
            <div class="card-body">
                <form v-on:submit.prevent="login">
                    <div class="form-group">
                        <label for="emailInput">Email</label>
                        <input class="form-control" v-model="user.email" id="emailInput" type="email" aria-describedby="emailHelp">
                        <div class="invalid-feedback" v-if="errors.email">{{errors.email[0]}}</div>
                    </div>
                    <div class="form-group">
                        <label for="passwordInput">Şifre</label>
                        <input class="form-control" v-model="user.password" id="passwordInput" type="password">
                        <div class="invalid-feedback" v-if="errors.password">{{errors.password[0]}}</div>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" v-model="user.remember_me" type="checkbox"> Şifremi Hatırla</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block" >Giriş</button>
                </form>
                <div class="text-center">
                    <router-link to="/register" class="d-block small mt-3">Kullanıcı Kaydı</router-link>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import * as auth from "../../services/auth_service";

export default {
    name: 'Login',
    data() {
        return {
            user: {
                email: '',
                password: '',
                remember_me: false
            },

            errors: {}
        }
    },
    methods: {
        login: async function() {
            try {
                const response = await auth.login(this.user);
                this.errors = {};
                this.$router.push('/dashboard');
            } catch (error) {
                switch (error.response.status_code) {
                    case 422:
                        this.errors = error.response.data.errors;
                        break;
                    case 401:
                        this.flashMessage.error({
                            message: error.response.data.message,
                            time: 5000
                        });
                        break;
                    case 500:
                        this.flashMessage.error({
                            message: error.response.data.message,
                            time: 5000
                        });
                        break;
                    default:
                        this.flashMessage.error({
                            message: 'Bir hata Oluştu',
                            time: 5000
                        });
                        break;

                }
            }
        }
    }
}
</script>
