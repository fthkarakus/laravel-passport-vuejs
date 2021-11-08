<template>
    <div class="container">
        <div class="card card-register mx-auto mt-5">
            <div class="card-header">Öğrenci Bilgi Sistemi Kullanıcı Kaydı</div>
            <div class="card-body">
                <form v-on:submit.prevent="register">
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-6">
                                <label for="nameInput">Ad Soyad</label>
                                <input class="form-control" v-model="user.name" id="nameInput" type="text" aria-describedby="nameHelp" placeholder="Ad Soyad">
                                <div class="invalid-feedback" v-if="errors.name">{{errors.name[0]}}</div>
                            </div>
                            <div class="col-md-6">
                                <label for="numberCodeInput">Verilen Kod</label>
                                <input class="form-control" v-model="user.student_number" id="numberCodeInput" type="text" aria-describedby="emailHelp" placeholder="Verilen Kod">
                                <div class="invalid-feedback" v-if="errors.student_number">{{errors.student_number[0]}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="emailInput">Email</label>
                        <input class="form-control" v-model="user.email" id="emailInput" type="email" aria-describedby="emailHelp" placeholder="Email">
                        <div class="invalid-feedback" v-if="errors.email">{{errors.email[0]}}</div>
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-6">
                                <label for="passwordInput">Şifre</label>
                                <input class="form-control" v-model="user.password" id="passwordInput" type="password" placeholder="Şifre">
                                <div class="invalid-feedback" v-if="errors.password">{{errors.password[0]}}</div>
                            </div>
                            <div class="col-md-6">
                                <label for="confirmpasswordInput">Şifre Tekrar</label>
                                <input class="form-control" v-model="user.password_confirmation" id="confirmpasswordInput" type="password" placeholder="Şifre Tekrar">
                                <div class="invalid-feedback" v-if="errors.password_confirmation">{{errors.password_confirmation[0]}}</div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block" >Kayıt Ol</button>
                </form>
                <div class="text-center">
                    <router-link to="/login" class="d-block small mt-3">Giriş</router-link>
                </div>
                <div class="panel panel-default" style="border: 1px solid #ccc;border-radius: 5px;padding: 20px;margin-top: 10px;">
                    <div class="panel-body">
                        <p><b>Kayıt esnasında aşağıdaki öğrenci numaralarını kullanabilirsiniz;</b></p>
                        <ul>
                            <li>20190345</li>
                            <li>20200593</li>
                            <li>20180056</li>
                            <li>20190346</li>
                            <li>20200597</li>
                            <li>20180146</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import * as auth from '../../services/auth_service';
export default {
    name: 'Register',
    data() {
        return {
            user: {
                name: '',
                student_number: '',
                email: '',
                password: '',
                password_confirmation: ''
            },
            errors: {}
        }
    },
    methods: {
        register: async function() {
            try {
                await auth.register(this.user);
                this.errors = {};
                this.user = {};
                this.flashMessage.success({
                    message: 'Kullanıcınız kaydınız oluşturulmuştur. Mailinize gelen linke tıklayarak sisteme giri sağlayabilirsiniz',
                    time: 5000
                });
            } catch (error) {
                switch (error.response.status) {
                    case 422:
                        this.errors = error.response.data.errors;
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
