describe('Loads home page', () => {
    it('has app name', () => {
        cy.visit('/');
        cy.contains("Laravel Startup")

    });

    it('Clicks on login will be redirected to login page', () => {
        cy.visit('/');

        cy.contains("Login").click();

        cy.url().should('include', '/login')
    })

    it('has privacy notice alert', () => {
        cy.visit('/');

        cy.contains('This site uses cookies and other tracking technologies to assist with navigation and to analyse site usage. By')
    });

    it('can dismiss privacy notice', () => {
        cy.visit('/');
        // got it button should exist
        cy.get('.mr-auto > .v-btn__content').should('exist');

        cy.get('span').contains('Got it').click();

        cy.get('.mr-auto > .v-btn__content').should('not.visible');
    })

})

