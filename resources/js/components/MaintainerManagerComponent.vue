<template>
<div class="modal large" id="maintainerManagerModal">
    <div class="modal-content">
        <h5>Module Maintainer</h5>
        <h6>Add Maintainer</h6>
        <div class="red-text" v-if="errorMessage">
            {{ errorMessage }}
        </div>
        <div class="row valign-wrapper">
            <div class="pl-0 col m10 input-field mt-0">
                <input type="email" id="email" v-model="email" placeholder="Email Address">
                <div class="helper-text red-text" v-if="errors['email']">{{ errors['email'].join(';') }}</div>
            </div>
            <div class="col m2 center-align">
                <button class="btn btn-flat" v-on:click="addMaintainer"><i class="material-icons">add</i></button>
            </div>
        </div>
        <ul class="collection">
            <li v-for="(username, index) in maintainer" :key="index" class="collection-item">
                <div class="row mb-0 valign-wrapper">
                    <div class="col m8">
                        {{ username }}
                    </div>
                    <div class="col m4 right-align">
                        <button class="right btn btn-floating waves-effect" v-on:click="removeMaintainer(index)"><i class="material-icons">delete</i></button>
                    </div>
                </div>
            </li>
        </ul>
    </div>
    <div class="modal-footer">
        <button class="modal-close btn btn-flat">close</button>
    </div>
</div>
</template>

<script>
export default {
    props: ["url", "maintainer_string"],
    data: function() {
        return {
            maintainer: [],
            email: "",
            errorMessage: "",
            errors: [],
        }
    },
    beforeMount() {
        this.maintainer = JSON.parse(this.maintainer_string);
    },
    methods: {
        removeMaintainer(index) {
            axios.delete(this.url + '/' + this.maintainer[index])
                .then((e) => {
                    this.maintainer.splice(index, 1);
                    M.toast({html: 'Maintainer has been removed'});
                })
        },
        addMaintainer() {
            this.errors = [];
            this.errorMessage = '';

            if(!this.email)
                return;

            axios.post(this.url, {
                email: this.email
            }).then((e) => {
                this.email = "";
                this.maintainer.push(e.data.username);
                M.toast({html: 'Maintainer has been added'});
            }).catch((e) => {
                const response = e.response;
                if(response.data.message)
                    this.errorMessage = response.data.message;
                
                if(response.data.errors)
                    this.errors = response.data.errors;
            })
        }
    }
}
</script>