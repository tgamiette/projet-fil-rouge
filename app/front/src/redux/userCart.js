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
            const { id } = action.payload;
            return state.cart.filter(item => item.id !== id);
        },
        emptyCart: (state) => {
            state.cart = null;
        },
    },
});

export const {addCart, removeCart, emptyCart} = userCart.actions;

export const selectCart = (state) => state.cart.cart;

export default userCart.reducer;
