import React from 'react';
import PropTypes from 'prop-types';
import { Container, Row, Col, Form, Button } from 'react-bootstrap';

export const LoginForm =({handleOnChange, handleOnSubmit, formSwitcher, email, pass}) => {
    return(
        <Container>
            <Row>
                <Col>
                <h1 className="text-info text-center">FlexOffice Login</h1>
                <hr />
                <Form autoComplete="off" onSubmit={handleOnSubmit}>
                    <Form.Group>
                        <Form.Label> Matricule </Form.Label>
                        <Form.Control
                        type="email"
                        name="email"
                        value={email}
                        onChange = {handleOnChange}
                        placeholder="Entrez Votre Matricule"
                        required
                        />
                    </Form.Group>
                    <br />
                    <Form.Group>
                        <Form.Label>Password</Form.Label>
                        <Form.Control
                        type="password"
                        name="password"
                        value={pass}
                        onChange = {handleOnChange}
                        placeholder="Enter password"
                        required
                        />

                    </Form.Group>
                    <br />
                    <Button type="submit">Login</Button>
                </Form>
                <hr />
                </Col>
            </Row>
            <Row>
                <Col>
                 <a href="#!" onClick={() =>formSwitcher('rest')}>Forget your password, just ask the IT guy !</a>
                </Col>
            </Row>
        </Container>
    );
};

LoginForm.propTypes = {
    handleOnChange: PropTypes.func.isRequired,
    handleOnSubmit: PropTypes.func.isRequired,
    formSwitcher : PropTypes.func.isRequired,
    email: PropTypes.string.isRequired,
    pass: PropTypes.string.isRequired,
};