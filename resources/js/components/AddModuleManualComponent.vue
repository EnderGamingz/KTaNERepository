<template>
<div class="modal large" id="addManualModal">
    <div class="modal-content">
        <h5 class="mt-0">Add Manual</h5>
        <div class="red-text" v-if="errorMessage">
            {{ errorMessage }}
        </div>
        <h6>Basic information</h6>
        <div class="input-field mt-2">
            <label for="language">Language</label>
            <input type="text" id="language" v-model="language">
        </div>
        <div class="input-field">
            <select name="type" id="type" v-model="type">
                <option value="">Normal / Original</option>
                <option value="embellished">Embellished</option>
                <option value="reworded">Reworded</option>
                <option value="reorganized">Reorganized</option>
                <option value="condensed">Condensed</option>
                <option value="lookup_table">Lookup Table</option>
                <option value="interactive">Interactive</option>
            </select>
            <label for="type">Type</label>
        </div>
        <h6>File Upload</h6>
        <div class="file-field input-field mt-4">
            <div class="btn">
                <span>File</span>
                <input type="file" @change="onFileChanged" name="files[]" id="files" multiple directory="" webkitdirectory="" moxdirectory="">
            </div>
            <div class="file-path-wrapper">
                <input class="file-path validate" type="text" placeholder="Upload one or more files">
            </div>
        </div>
        </div>
    <div class="modal-footer">
        <button class="btn btn-flat modal-close">Close</button>
        <button class="btn" v-on:click="uploadFiles">Upload</button>
    </div>
</div>
</template>

<script>
export default {
    props: ['url'],
    data: function() {
        return {
            errorMessage: "",
            language: "English",
            files: [],
            type: "",
        }
    },
    methods: {
        onFileChanged(event) {
            this.files = event.target.files;
        },
        uploadFiles() {
            var formData = new FormData();
            
            for(let i = 0; i < this.files.length; i++) {
                formData.append('files['+ i + ']', this.files[i]);
            }

            formData.append('type', this.type);
            formData.append('language', this.language);

            axios.post(this.url, formData).then((e) => {
                if(e.data.redirect_url)
                    window.location.href= e.data.redirect_url;
            })
        }
    }
}
</script>