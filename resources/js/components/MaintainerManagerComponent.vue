<template>
<div class="modal large" id="maintainerManagerModal">
    <div class="modal-content">
        <h5>Module Maintainer</h5>
        <h6>Add Maintainer</h6>
        <div class="row valign-wrapper">
            <div class="pl-0 col m10 input-field mt-0">
                <label for="email">Email</label>
                <input type="email" id="email" v-model="email">
            </div>
            <div class="col m2 center-align">
                <button class="btn btn-flat" v-on:click="addMaintainer"><i class="material-icons">add</i></button>
            </div>
        </div>
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
        }
    },
    beforeMount() {
        this.maintainer = JSON.parse(this.maintainer_string);
    },
    methods: {
        addMaintainer() {
            if(!this.email)
                return;
            
            axios.post(this.url, {
                email: this.email
            }).then((e) => {
                this.maintainer.push(e.data.username);
            }).catch((e) => {
                console.log(e);
                // M.toast({html: e.response});
            })
        }
    }
}
</script>