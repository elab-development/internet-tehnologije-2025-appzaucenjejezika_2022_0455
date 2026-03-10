describe('Login flow', () => {
  it('korisnik se može ulogovati', () => {
    cy.visit('http://localhost:5173/login')

    cy.get('input[type="email"]').type('test@test.com')
    cy.get('input[type="password"]').type('password123')
    cy.get('button[type="submit"]').click()

    cy.url().should('include', '/courses')
  })
})