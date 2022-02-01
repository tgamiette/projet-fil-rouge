import React, { useState } from 'react'
import './Entry.page.css'
import { LoginForm } from '../../components/login/Login.form'


// modification useState du login
export const Entry = () => {
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');

    const handleEmailChange = (e) => {
        const { name, value } = e.target;
        // Ecriture dans les cases
        switch (name) {
            case 'email':
                setEmail(value);
                break;

            case 'password':
                setPassword(value);
                break;

            default:
                break;
        };


        const handleOnSubmit = (e) => {
            e.preventDefault();

            if (!email || !password) {
                return alert('Veuillez remplir tous les champs');
            }
            // Todo call api to submit form
        };
    }




    // login Form page
    return ( <
        div className = "entry-page bg-info" >
        <
        div className = "form-box" >
        <
        LoginForm handleEmailChange = { handleEmailChange }
        email = { email }
        password = { password }
        />

        <
        /div> <
        /div>
    )
};