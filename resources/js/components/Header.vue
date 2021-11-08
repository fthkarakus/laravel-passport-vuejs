<template>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
            <router-link to="/dashboard" class="navbar-brand">Turk Ai</router-link>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
                    <li class="nav-item" data-toggle="tooltip" data-placement="right" >
                        <router-link to="/dashboard" class="nav-link" exact>
                            <i class="fa fa-fw fa-dashboard"></i>
                            <span class="nav-link-text">Dashboard</span>
                        </router-link>
                    </li>
                    <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts">
                        <router-link to="/profile" class="nav-link" exact>
                            <i class="fa fa-fw fa-area-chart"></i>
                            <span class="nav-link-text">Profilim</span>
                        </router-link>
                    </li>

                </ul>
                <ul class="navbar-nav sidenav-toggler">
                    <li class="nav-item">
                        <a class="nav-link text-center" id="sidenavToggler">
                            <i class="fa fa-fw fa-angle-left"></i>
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link"  v-on:click="logout"><i class="fa fa-fw fa-sign-out"></i> Çıkış</a>
                    </li>
                </ul>
            </div>
        </nav>
</template>

<script>
import * as auth from "../services/auth_service";
export default {
    methods: {
        logout: async function() {
            auth.logout();
            this.$router.push('/login');
        }
    }
}
</script>
