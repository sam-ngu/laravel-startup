describe('User Auth', () => {

    it('can see the login page', () => {
        cy.visit('/login')

        cy.contains('Sign in');



    });

    it('can validate user input', () => {

        const emailInput = cy.get('#input-16');

        emailInput.type('aaa');

        const emailInputDetails = cy.get('.v-messages__message');

        emailInputDetails.contains('Incorrect format');

    });

    it('accepts valid email format', () => {
        const emailInput = cy.get('#input-16');

        emailInput.clear().type('a@a.com');

        cy.get('.v-input--is-label-active.v-text-field')
            .should('not.contain', 'Incorrect format');

    });

    it('can log user in', () => {
        cy.refreshDatabase();
        const email = 'test@test.com';
        const password = 'secret';
        cy.create('App\\Models\\User', {email, password});

        const emailInput = cy.get('#input-16');
        const passwordInput = cy.get('#input-19');

        emailInput.clear().type(email);
        passwordInput.clear().type(password);
        cy.contains('Login').click();

        // cy.get('@post').should('have.property', 'status', 200);

    });


})
