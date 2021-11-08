<template>

    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item active"><b>Sayın, {{profile.name}}</b></li>
        </ol>

        <!-- Area Chart Example-->
        <div class="card mb-3">
            <div class="card-header d-flex">
                <span><i class="fa fa-area-chart"></i> Üye Bilgileriniz</span>
                <button class="btn btn-primary btn-sm ml-auto" v-on:click="editProfile(profile)"><span class="fa fa-plus"></span> Bilgilerinizi Güncelleyin</button>
            </div>
            <div class="card-body">
                <table class="table">
                    <tbody>
                    <tr>
                        <td>Adı Soyadı</td>
                        <td>:</td>
                        <td>{{profile.name}}</td>
                    </tr>
                    <tr>
                        <td>Email Adresi</td>
                        <td>:</td>
                        <td>{{profile.email}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-header d-flex">
                <span><i class="fa fa-area-chart"></i> Öğrenci Bilgileriniz</span>
            </div>
            <div class="card-body">
                <table class="table">
                    <tbody>
                    <tr>
                        <td>Öğrenci Adı Soyadı</td>
                        <td>:</td>
                        <td>{{profile[0].name}}</td>
                    </tr>
                    <tr>
                        <td>Bölümü</td>
                        <td>:</td>
                        <td>{{profile[0].section}}</td>
                    </tr>
                    <tr>
                        <td>Sınıfı</td>
                        <td>:</td>
                        <td>{{profile[0].section_class}}</td>
                    </tr>
                    <tr>
                        <td>Öğrenci Numarası</td>
                        <td>:</td>
                        <td>{{profile[0].student_number}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <b-modal ref="editProfileModal" hide-footer title="Profil Güncelle">
            <div class="d-block">
                <form v-on:submit.prevent="updateProfile">
                    <div class="form-group">
                        <label for="name">Adınız Soyadınız </label>
                        <input type="text" v-model="editProfileData.name" class="form-control" id="name">
                        <div class="invalid-feedback" v-if="errors.name">{{errors.name[0]}}</div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email Adresiniz</label>
                        <input type="email" v-model="editProfileData.email" class="form-control" id="email">
                        <div class="invalid-feedback" v-if="errors.email">{{errors.email[0]}}</div>
                    </div>
                    <div class="form-group">
                        <label for="password">Şifreniz</label>
                        <input type="password" v-model="editProfileData.password" class="form-control" id="password">
                        <div class="invalid-feedback" v-if="errors.password">{{errors.password[0]}}</div>
                    </div>

                    <hr>
                    <div class="text-right">
                        <button type="button" class="btn btn-info" v-on:click="hideEditProfileModal">Vazgeç</button>
                        <button type="submit" class="btn btn-primary"><span class="fa fa-check"></span> Güncelle</button>
                    </div>
                </form>
            </div>
        </b-modal>
    </div>
</template>

<script>
import * as profileServices from '../services/profile_service';
export default {
    name: 'profil',
    data() {
        return {
            profile: [],
            profileDate: {
                name: '',
                email: '',
                password: '',
                password_confirmation: ''
            },
            editProfileData: {},
            errors: {}
        }
    },
    mounted() {
        this.loadProfile();
    },
    methods: {
        loadProfile: async function() {
            try {
                const token = localStorage.getItem('turkai-token')
                const response = await profileServices.loadProfile();
                this.profile = response.data;
            } catch (e) {
                this.flashMessage.error({
                    message: 'Some error occured, Please refresh',
                    time: 5000
                });
            }
        },
        hideEditProfileModal() {
            this.$refs.editProfileModal.hide();
        },
        showEditProfileModal() {
            this.$refs.editProfileModal.show();
        },
        editProfile(profile){
            this.editProfileData = {...profile};
            this.showEditProfileModal();
        },
        updateProfile: async function() {
            try {
                const formData = new FormData();
                formData.append('name', this.editProfileData.name);
                formData.append('email', this.editProfileData.email);
                formData.append('password', this.editProfileData.password);
                formData.append('_method', 'put')

                const response =  profileServices.updateProfile(this.editProfileData.id,formData);
                this.loadProfile();
                this.hideEditProfileModal();
                this.flashMessage.success({
                    message: 'Profil güncellendi',
                    time: 5000
                });
            } catch (error) {
                this.flashMessage.error({
                    message: error.response.data.message,
                    time: 5000
                });
            }
        }

    }
}
</script>
