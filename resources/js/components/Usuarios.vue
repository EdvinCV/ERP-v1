<template>
    <form>
        <v-text-field
            v-model="nombreUsuario"
            :error-messages="errores"
            :counter="10"
            label="Name"
            required
        ></v-text-field>

        <v-text-field
            v-model="email"
            :rules="[rules.required, rules.email]"
            label="E-mail"
        ></v-text-field>

        <v-text-field
            v-model="password"
            :append-icon="mostrar ? 'visibility' : 'visibility_off'"
            :rules="[rules.required, rules.min]"
            :type="mostrar ? 'text' : 'password'"
            name="input-10-1"
            label="Ingrese contraseña"
            hint="Al menos 8 caracteres"
            counter
            @click:append="mostrar = !mostrar>1"
          ></v-text-field>

          <v-text-field
            v-model="passwordVerificada"
            :append-icon="mostrar ? 'visibility' : 'visibility_off'"
            :rules="[rules.required, rules.min]"
            :type="mostrar ? 'text' : 'password'"
            name="input-10-1"
            label="Confirmar contraseña"
            hint="Al menos 8 caracteres"
            counter
            @click:append="mostrar = !mostrar"
          ></v-text-field>
    </form>



</template>

<script>
export default {
    data: () => ({
        mostrar: false,
        rules: {
          required: value => !!value || 'Required.',
          counter: value => value.length <= 20 || 'Max 20 characters',
          email: value => {
            const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
            return pattern.test(value) || 'Correo electrónico invalido.'
          },
        }
    })
}
</script>