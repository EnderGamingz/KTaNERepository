<template>
<div>
    <div class="row mb-0">
        <div class="col s12 m6">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Module Information</span>
                    <div class="row mb-0">
                        <div class="col s12 m6 input-field">
                            <label for="name">Name</label>
                            <input type="text" v-on:input="generateUID" required class="char-count" data-length="100" id="name" v-model="name" maxlength="100">
                            <div class="helper-text red-text" v-if="errors['name']">
                                {{ errors['name'] }}
                            </div>
                        </div>
                        <div class="col s12 m6 input-field">
                            <input type="text" readonly v-model="uid" value=" " id="uid">
                            <label for="uid">UID</label>
                        </div>
                    </div>
                    <div class="input-field">
                        <label for="description">Description</label>
                        <input type="text" required class="char-count" data-length="255" id="description" v-model="description" maxlength="255">
                        <div class="helper-text red-text" v-if="errors['description']">
                            {{ errors['description'] }}
                        </div>
                    </div>
                    <div class="input-field">
                        <label for="credits">Credits</label>
                        <input type="text" v-model="credits" id="credits">
                        <div class="helper-text green-text">
                            Use comma seperation for multiple authors
                        </div>
                        <div class="helper-text red-text" v-if="errors['credits']">
                            {{ errors['credits'] }}
                        </div>
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
                    <span class="card-title">Links</span>
                    <div class="red-text" v-if="linkErrors">
                        {{ linkErrors }}
                    </div>
                    <div class="row">
                        <div class="col m5 s12 input-field">
                            <select id="link_type" v-model="linkType">
                                <option value="" disabled selected>Select Type</option>
                                <option v-for="(name, index) in avaliableLinks" :key="index" :value="index">{{ name }}</option>
                            </select>
                        </div>
                        <div class="col m5 s12 input-field">
                            <input type="url" id="linkUrl" v-model="linkUrl">
                            <label for="linkUrl">URL</label>
                        </div>
                        <div class="col m2 s12">
                            <button class="btn btn-flat mt-3" v-on:click="addLink"><i class="material-icons">add</i></button>
                        </div>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>URL</th>
                                <th> </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(data,index) in links" :key="index">
                                <td>{{ avaliableLinks[index] }}</td>
                                <td>{{ data }}</td>
                                <td class="right-align">
                                    <button class="btn btn-flat" v-on:click="removeLink(index)"><i class="material-icons">delete</i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
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
                            <button v-on:click="addMetadata" class="btn btn-flat mt-3"><i class="material-icons">add</i></button>
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
    <div class="row">
        <div class="col s12 m6">
            <div class="card-panel py-1">
                <div class="right-align">
                    <button class="btn" :disabled="requestPending" v-on:click="submitForm">
                        <div class="preloader-wrapper button active" v-if="requestPending">
                            <div class="spinner-layer spinner-blue-only">
                                <div class="circle-clipper left"><div class="circle"></div></div>
                                <div class="gap-patch"><div class="circle"></div></div>
                                <div class="circle-clipper right"><div class="circle"></div></div>
                            </div>
                        </div>
                        Create
                    </button>
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
            uid: " ",
            credits: "",
            errors: {},
            requestPending: false,
            links: {},
            linkType: "",
            linkUrl: "",
            linkErrors: null,
            avaliableLinks: {
                github: "GitHub",
                website: "Website",
                steam: "Steam Workshop",
            }
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
                    placeholder: "Tags",
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
        },
        addLink() {
            this.linkErrors = "";
            if(!this.linkType || !this.linkUrl) {
                return;
            }  

            if(this.links[this.linkType]) {
                this.linkErrors = "The link type '" + this.avaliableLinks[this.linkType] + "' is already set";
                return;
            }

            if(!this.validURL(this.linkUrl)) {
                this.linkErrors = "The entered URL is not valid";
                return;
            }

            this.$set(this.links, this.linkType, this.linkUrl);
            this.linkType = "";
            this.linkUrl = "";
        },
        removeLink(index) {
            this.$delete(this.links, index);
        },
        handleFormErrors(error) {
            const data = JSON.parse(error.responseText);
            this.errors = {};
            for (const [key, value] of Object.entries(data.errors)) {
                this.$set(this.errors, key, value.join('<br>'));
            }
        },
        submitForm() {
            this.errors = {};

            let tags = [];
            const instance = M.Chips.getInstance(document.getElementById('tags'));
            instance.chipsData.forEach((data) => {
                tags.push(data.tag);
            });

            const credits = this.credits ? this.credits.split(',') : [];
            this.requestPending = true;
            axios.post(this.url, {
                name: this.name,
                description: this.description,
                expert_difficulty: this.expertDifficulty,
                defuser_difficulty: this.defuserDifficulty,
                tags: tags,
                metadata: this.metadata,
                credits: credits,
                links: this.links,
            }).then((e) => {
                this.requestPending = false;
            }).catch((e) => {
                this.requestPending = false;
                if(e.request.status === 422)
                    this.handleFormErrors(e.request);
            });
        },
        validURL(str) {
            const pattern = new RegExp('^(https?:\\/\\/)?'+         // protocol
                '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|'+ // domain name
                '((\\d{1,3}\\.){3}\\d{1,3}))'+                      // OR ip (v4) address
                '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*'+                  // port and path
                '(\\?[;&a-z\\d%_.~+=-]*)?'+                         // query string
                '(\\#[-a-z\\d_]*)?$','i');                          // fragment locator
            return !!pattern.test(str);
        },
    }
}
</script>