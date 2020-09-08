<template>
<div>
    <div class="row valign-wrapper">
        <div class="col m10 input-field">
            <label for="moduleName">Module UID</label>
            <input type="text" v-model="moduleName" id="moduleName">
        </div>
        <div class="col m2">
            <button class="btn btn-flat" v-on:click="addModule">
                <i class="material-icons">add</i>
            </button>
        </div>
    </div>
    <table v-if="moduleIds.length > 0">
        <thead>
            <tr>
                <th>Module UID</th>
                <th> </th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(id, index) in moduleIds" :key="index">
                <td>{{ id }}</td>
                <td class="right-align">
                    <button class="btn btn-floating btn-small" v-on:click="moduleIds.splice(index, 1)">
                        <i class="material-icons">delete</i>
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
</template>

<script>
export default {
    data: function() {
        return {
            moduleName: "",
            moduleIds: [],
        }
    },
    mounted() {
        this.$parent.$on('add_module_capability_fetch_data', (callback) => {
            callback({Ignore: this.moduleIds});
        });
    },
    methods: {
        addModule() {
            if(!this.moduleName)
                return;

            this.moduleIds.push(this.moduleName);
            this.moduleName = "";
        }
    }
}
</script>