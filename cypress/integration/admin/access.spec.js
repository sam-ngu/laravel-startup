describe('Allow admin user to enter only', () => {
    it('kick non-admin user out', () => {
        cy.login({ first_name: 'jon', last_name: 'doe'});

        cy.visit('/admin')

        cy.location('pathname').should('be', '/');

        cy.logout();
    });

    it('let admin users in', () => {
        cy.refreshDatabase();
        cy.seed('AuthTableSeeder');
        cy.login({ email: 'admin@admin.com'});
        cy.visit('/admin');
        cy.url().should('match', /admin/);
        cy.location('pathname').should('contain', 'admin');
    });
})
