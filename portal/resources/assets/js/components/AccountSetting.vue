<template>
	<div class="col-md-4 col-sm-12 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Account Settings
            </div>
            <div class="panel-body">
                <div class="list-group">
                    <span class="list-group-item">
                     Name: {{ userObject.name }}
                    </span>
                    <span class="list-group-item">
                     Email: {{userObject.email}}
                    </span>
                    <!-- <span class="list-group-item">
                     Contact
                    </span> -->
                </div>
                <div class="text-right">
                    <a href="#" @click="showModal=true">Account Settings <i class="fa fa-arrow-circle-right"></i></a>
                </div>
                <recoverymodal :user="userObject" :show="showModal" @close="showModal = false"></recoverymodal>
            </div>
        </div>
    </div>
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
    created() {
            this.userObject = JSON.parse(this.user);
        }
}
</script>