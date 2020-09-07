<template>
<div>
    <div class="row">
        <div class="col s12 m6">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Module Information</span>
                    <div class="row">
                        <div class="col s12 m6 input-field">
                            <label for="name">Name</label>
                            <input type="text" v-on:input="generateUID" required class="char-count" data-length="100" id="name" v-model="name" name="name" maxlength="100">
                        </div>
                        <div class="col s12 m6 input-field">
                            <input type="text" readonly value=" " id="uid">
                            <label for="uid">UID</label>
                        </div>
                    </div>
                    <div class="input-field">
                        <label for="description">Description</label>
                        <input type="text" required class="char-count" data-length="255" id="description" v-model="description" name="description" maxlength="255">
                    </div>
                    <div class="row">
                        <div class="col s12 m6 input-field">
                            <label for="expert_difficulty">Expert Difficulty</label>
                            <input value="1" type="number" min="1" max="100" id="expert_difficulty" v-model="expertDifficulty" name="expert_difficulty" required>
                        </div>
                        <div class="col s12 m6 input-field">
                            <label for="defuser_difficulty">Defuser Difficulty</label>
                            <input value="1" type="number" min="1" max="100" id="defuser_difficulty" v-model="defuserDifficulty" name="defuser_difficulty" required>
                        </div>
                    </div>
                    <div class="chips" id="tags"></div>
                </div>
            </div>
        </div>
        <div class="col s12 m6">
            <div class="card">
                <div class="card-content">
                    <div class="row valign-wrapper">
                        <div class="col m8">
                            <span class="card-title">Metadata</span>
                        </div>
                        <div class="col m4 right-align">
                            <button class="btn btn-floating btn-sm"><i class="material-icons">help</i></button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 m5 input-field">
                            <label for="key">Key</label>
                            <input type="text" v-model="key" name="key" id="key">
                        </div>
                        <div class="col s12 m5 input-field">
                            <label for="value">Value</label>
                            <textarea class="materialize-textarea" v-model="value" name="value" id="value" cols="30" rows="10"></textarea>
                        </div>
                        <div class="col s12 m2">
                            <button v-on:click="addMetadata" class="btn btn-flat mt-2"><i class="material-icons">add</i></button>
                        </div>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Key</th>
                                <th>Value</th>
                                <th> </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(data,index) in metadata" :key="index">
                                <td>{{ index }}</td>
                                <td>{{ data }}</td>
                                <td class="right-align">
                                    <button class="btn btn-flat" v-on:click="removeMetadata(index)"><i class="material-icons">delete</i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    props: ['url', 'tag_url'],
    data: function() {
        return {
            description: "",
            name: "",
            uid: "",
            expertDifficulty: 1,
            defuserDifficulty: 1,
            metadata: {},
            key: "",
            value: "",
            uid: "",
        }
    },
    mounted: function() {
        axios.get(this.tag_url)
            .then((e) => {
                console.log(e.data);
                // Make an empty data object
                let data = {};
                // Iterate over the recived data
                e.data.forEach(d => {
                    data[d] = null;
                });
                // Make the chip instance
                let chips = $('#tags').chips({
                    autocompleteOptions: {
                        data: data,
                        limit: 'Infinity',
                        minLength: 1,
                    },
                    placeholder: "Tag",
                    secondaryPlaceholder: "+Tag",
                });
            }).catch((e) => {
                console.error(e);
                M.toast({html: 'Could not load tags: ' + e});
            });
    },
    methods: {
        addMetadata() {
            if(!this.key || !this.value) {
                return;
            }
            this.$set(this.metadata, this.key, this.value);
            this.key = "";
            this.value = "";
        },
        removeMetadata(index) {
            if(!index) {
                return;
            }
            this.$delete(this.metadata, index);
        },
        generateUID() {
            this.uid = this.name.replace(/[^A-Za-z0-9]/mg, '');
        }
    }
}
</script>