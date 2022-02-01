import React from 'react';
import { Navbar, Nav } from 'react-bootstrap';

export const Header = () => {
  return (
    <Navbar
    collapseOnSelect
    bg="dark"
    variant="dark"
    expand="md"
    >
        <Navbar.Brand href="#home">
            This is header
        </Navbar.Brand>
        <Navbar.Toggle
        aria-controls="basic-navbar-nav" />
        <Navbar.Collapse id="basic-navbar-nav">
            <Nav.Link href="#home">Home</Nav.Link>
            <Nav.Link href="#home">Dashboard</Nav.Link>
            <Nav.Link href="#home">Map thing</Nav.Link>
            <Nav.Link href="#home">Logout</Nav.Link>
        </Navbar.Collapse>
    </Navbar>
  );
};
