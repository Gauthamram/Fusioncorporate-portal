<template>
	<ul class="nav navbar-top-links navbar-right" v-if="user">
        <li class="dropdown" :class="{'open': isVisible}">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false" @click="toggle()">
                <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user" v-if="user">
                <li><a href="#" @click="showModal=true"><i class="fa fa-cog fa-fw"></i>User Setting</a>
                </li>
                <li><a :href="logoutUrl"><i class="fa fa-sign-out fa-fw"></i>Logout</a></li>
            </ul>
            <recoverymodal :user="userObject" :show="showModal" @close="showModal = false"></recoverymodal>
            <!-- /.dropdown-user -->
        </li>
        <!-- /.dropdown -->
    </ul>
</template>

<script>
import recoverymodal from './RecoveryModal.vue';
export default {
    props: {
        user: { required: true }
    },
    components: {
        recoverymodal: recoverymodal
    },
    data() {
        return {
            isVisible: false,
            showModal: false,
            userObject: { }
        }
    },
    computed: {
        logoutUrl() {
            return "/user/logout";
        }
    },
    methods: {
        toggle() {
            this.isVisible = !this.isVisible;
        }
    },
    mounted() {
            this.userObject = JSON.parse(this.user);
        }
}
</script>