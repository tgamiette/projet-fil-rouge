import { createSlice } from "@reduxjs/toolkit";

export const userCart = createSlice({
    name:"cart",
    initialState:{
        cart: [],
    },
    reducers:{
        addCart: (state, action) => {
            const {id, quantity, name, price} = action.payload;
            state.cart.push({id, quantity, name, price});
        },
        removeCart: (state, action) => {
            const { id, cart} = action.payload;
            state.cart = cart;
        },
        emptyCart: (state, action) => {
            return [];
        },
    },
});

export const {addCart, removeCart, emptyCart} = userCart.actions;

export const selectCart = (state) => state.cart.cart;

export default userCart.reducer;
