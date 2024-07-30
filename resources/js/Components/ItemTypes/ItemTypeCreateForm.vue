<template>

    <Form @submit="handleSubmit" :validation-schema="schema">

        <div class="form-group">
            <label>Name</label>
            <Field type="text" class="form-control" autocomplete="off" name="name" />
            <ErrorMessage name="name" class="text-danger"/>
        </div>

        <div class="form-group">
            <label>New Item</label>
            <Field type="text" class="form-control" id="new_item" autocomplete="off" name="new_item" />
            <ErrorMessage name="new_item" class="text-danger"/>
        </div>

        <button class="btn btn-primary mt-2">Submit</button>

    </Form>

</template>

<script>

import {Form, Field, ErrorMessage } from 'vee-validate';
import * as yup from 'yup';
import axios from 'axios';

export default {
    components: { Form, Field, ErrorMessage },
    mounted() {
        console.log("Component mounted.");
    },
    data() {
        const schema = yup.object({
            name: yup.string().required(),
            new_item: yup.string().required()
        });
        return {
            schema
        };
    },
    methods: {
        handleSubmit(values)
        {
            console.log(values);
            // submit to form
            axios.post('http://127.0.0.1:8000/add-item-types', values).then(res =>{
                console.log('res');
                console.log(res);
            }).catch(err =>{
                console.log('err');
            })
        }
    }
};

</script>